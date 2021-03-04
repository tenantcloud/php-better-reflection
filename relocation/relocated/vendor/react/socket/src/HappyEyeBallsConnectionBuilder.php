<?php

namespace TenantCloud\BetterReflection\Relocated\React\Socket;

use TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message;
use TenantCloud\BetterReflection\Relocated\React\Dns\Resolver\ResolverInterface;
use TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface;
use TenantCloud\BetterReflection\Relocated\React\EventLoop\TimerInterface;
use TenantCloud\BetterReflection\Relocated\React\Promise;
use TenantCloud\BetterReflection\Relocated\React\Promise\CancellablePromiseInterface;
/**
 * @internal
 */
final class HappyEyeBallsConnectionBuilder
{
    /**
     * As long as we haven't connected yet keep popping an IP address of the connect queue until one of them
     * succeeds or they all fail. We will wait 100ms between connection attempts as per RFC.
     *
     * @link https://tools.ietf.org/html/rfc8305#section-5
     */
    const CONNECTION_ATTEMPT_DELAY = 0.1;
    /**
     * Delay `A` lookup by 50ms sending out connection to IPv4 addresses when IPv6 records haven't
     * resolved yet as per RFC.
     *
     * @link https://tools.ietf.org/html/rfc8305#section-3
     */
    const RESOLUTION_DELAY = 0.05;
    public $loop;
    public $connector;
    public $resolver;
    public $uri;
    public $host;
    public $resolved = array(\TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message::TYPE_A => \false, \TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message::TYPE_AAAA => \false);
    public $resolverPromises = array();
    public $connectionPromises = array();
    public $connectQueue = array();
    public $nextAttemptTimer;
    public $parts;
    public $ipsCount = 0;
    public $failureCount = 0;
    public $resolve;
    public $reject;
    public $lastErrorFamily;
    public $lastError6;
    public $lastError4;
    public function __construct(\TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface $loop, \TenantCloud\BetterReflection\Relocated\React\Socket\ConnectorInterface $connector, \TenantCloud\BetterReflection\Relocated\React\Dns\Resolver\ResolverInterface $resolver, $uri, $host, $parts)
    {
        $this->loop = $loop;
        $this->connector = $connector;
        $this->resolver = $resolver;
        $this->uri = $uri;
        $this->host = $host;
        $this->parts = $parts;
    }
    public function connect()
    {
        $timer = null;
        $that = $this;
        return new \TenantCloud\BetterReflection\Relocated\React\Promise\Promise(function ($resolve, $reject) use($that, &$timer) {
            $lookupResolve = function ($type) use($that, $resolve, $reject) {
                return function (array $ips) use($that, $type, $resolve, $reject) {
                    unset($that->resolverPromises[$type]);
                    $that->resolved[$type] = \true;
                    $that->mixIpsIntoConnectQueue($ips);
                    // start next connection attempt if not already awaiting next
                    if ($that->nextAttemptTimer === null && $that->connectQueue) {
                        $that->check($resolve, $reject);
                    }
                };
            };
            $that->resolverPromises[\TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message::TYPE_AAAA] = $that->resolve(\TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message::TYPE_AAAA, $reject)->then($lookupResolve(\TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message::TYPE_AAAA));
            $that->resolverPromises[\TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message::TYPE_A] = $that->resolve(\TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message::TYPE_A, $reject)->then(function (array $ips) use($that, &$timer) {
                // happy path: IPv6 has resolved already, continue with IPv4 addresses
                if ($that->resolved[\TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message::TYPE_AAAA] === \true) {
                    return $ips;
                }
                // Otherwise delay processing IPv4 lookup until short timer passes or IPv6 resolves in the meantime
                $deferred = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred();
                $timer = $that->loop->addTimer($that::RESOLUTION_DELAY, function () use($deferred, $ips) {
                    $deferred->resolve($ips);
                });
                $that->resolverPromises[\TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message::TYPE_AAAA]->then(function () use($that, $timer, $deferred, $ips) {
                    $that->loop->cancelTimer($timer);
                    $deferred->resolve($ips);
                });
                return $deferred->promise();
            })->then($lookupResolve(\TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message::TYPE_A));
        }, function ($_, $reject) use($that, &$timer) {
            $reject(new \RuntimeException('Connection to ' . $that->uri . ' cancelled' . (!$that->connectionPromises ? ' during DNS lookup' : '')));
            $_ = $reject = null;
            $that->cleanUp();
            if ($timer instanceof \TenantCloud\BetterReflection\Relocated\React\EventLoop\TimerInterface) {
                $that->loop->cancelTimer($timer);
            }
        });
    }
    /**
     * @internal
     * @param int      $type   DNS query type
     * @param callable $reject
     * @return \React\Promise\PromiseInterface<string[],\Exception> Returns a promise
     *     that resolves list of IP addresses on success or rejects with an \Exception on error.
     */
    public function resolve($type, $reject)
    {
        $that = $this;
        return $that->resolver->resolveAll($that->host, $type)->then(null, function (\Exception $e) use($type, $reject, $that) {
            unset($that->resolverPromises[$type]);
            $that->resolved[$type] = \true;
            if ($type === \TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message::TYPE_A) {
                $that->lastError4 = $e->getMessage();
                $that->lastErrorFamily = 4;
            } else {
                $that->lastError6 = $e->getMessage();
                $that->lastErrorFamily = 6;
            }
            // cancel next attempt timer when there are no more IPs to connect to anymore
            if ($that->nextAttemptTimer !== null && !$that->connectQueue) {
                $that->loop->cancelTimer($that->nextAttemptTimer);
                $that->nextAttemptTimer = null;
            }
            if ($that->hasBeenResolved() && $that->ipsCount === 0) {
                $reject(new \RuntimeException($that->error()));
            }
            throw $e;
        });
    }
    /**
     * @internal
     */
    public function check($resolve, $reject)
    {
        $ip = \array_shift($this->connectQueue);
        // start connection attempt and remember array position to later unset again
        $this->connectionPromises[] = $this->attemptConnection($ip);
        \end($this->connectionPromises);
        $index = \key($this->connectionPromises);
        $that = $this;
        $that->connectionPromises[$index]->then(function ($connection) use($that, $index, $resolve) {
            unset($that->connectionPromises[$index]);
            $that->cleanUp();
            $resolve($connection);
        }, function (\Exception $e) use($that, $index, $ip, $resolve, $reject) {
            unset($that->connectionPromises[$index]);
            $that->failureCount++;
            if (\strpos($ip, ':') === \false) {
                $that->lastError4 = $e->getMessage();
                $that->lastErrorFamily = 4;
            } else {
                $that->lastError6 = $e->getMessage();
                $that->lastErrorFamily = 6;
            }
            // start next connection attempt immediately on error
            if ($that->connectQueue) {
                if ($that->nextAttemptTimer !== null) {
                    $that->loop->cancelTimer($that->nextAttemptTimer);
                    $that->nextAttemptTimer = null;
                }
                $that->check($resolve, $reject);
            }
            if ($that->hasBeenResolved() === \false) {
                return;
            }
            if ($that->ipsCount === $that->failureCount) {
                $that->cleanUp();
                $reject(new \RuntimeException($that->error()));
            }
        });
        // Allow next connection attempt in 100ms: https://tools.ietf.org/html/rfc8305#section-5
        // Only start timer when more IPs are queued or when DNS query is still pending (might add more IPs)
        if ($this->nextAttemptTimer === null && (\count($this->connectQueue) > 0 || $this->resolved[\TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message::TYPE_A] === \false || $this->resolved[\TenantCloud\BetterReflection\Relocated\React\Dns\Model\Message::TYPE_AAAA] === \false)) {
            $this->nextAttemptTimer = $this->loop->addTimer(self::CONNECTION_ATTEMPT_DELAY, function () use($that, $resolve, $reject) {
                $that->nextAttemptTimer = null;
                if ($that->connectQueue) {
                    $that->check($resolve, $reject);
                }
            });
        }
    }
    /**
     * @internal
     */
    public function attemptConnection($ip)
    {
        $uri = '';
        // prepend original scheme if known
        if (isset($this->parts['scheme'])) {
            $uri .= $this->parts['scheme'] . '://';
        }
        if (\strpos($ip, ':') !== \false) {
            // enclose IPv6 addresses in square brackets before appending port
            $uri .= '[' . $ip . ']';
        } else {
            $uri .= $ip;
        }
        // append original port if known
        if (isset($this->parts['port'])) {
            $uri .= ':' . $this->parts['port'];
        }
        // append orignal path if known
        if (isset($this->parts['path'])) {
            $uri .= $this->parts['path'];
        }
        // append original query if known
        if (isset($this->parts['query'])) {
            $uri .= '?' . $this->parts['query'];
        }
        // append original hostname as query if resolved via DNS and if
        // destination URI does not contain "hostname" query param already
        $args = array();
        \parse_str(isset($this->parts['query']) ? $this->parts['query'] : '', $args);
        if ($this->host !== $ip && !isset($args['hostname'])) {
            $uri .= (isset($this->parts['query']) ? '&' : '?') . 'hostname=' . \rawurlencode($this->host);
        }
        // append original fragment if known
        if (isset($this->parts['fragment'])) {
            $uri .= '#' . $this->parts['fragment'];
        }
        return $this->connector->connect($uri);
    }
    /**
     * @internal
     */
    public function cleanUp()
    {
        // clear list of outstanding IPs to avoid creating new connections
        $this->connectQueue = array();
        foreach ($this->connectionPromises as $connectionPromise) {
            if ($connectionPromise instanceof \TenantCloud\BetterReflection\Relocated\React\Promise\CancellablePromiseInterface) {
                $connectionPromise->cancel();
            }
        }
        foreach ($this->resolverPromises as $resolverPromise) {
            if ($resolverPromise instanceof \TenantCloud\BetterReflection\Relocated\React\Promise\CancellablePromiseInterface) {
                $resolverPromise->cancel();
            }
        }
        if ($this->nextAttemptTimer instanceof \TenantCloud\BetterReflection\Relocated\React\EventLoop\TimerInterface) {
            $this->loop->cancelTimer($this->nextAttemptTimer);
            $this->nextAttemptTimer = null;
        }
    }
    /**
     * @internal
     */
    public function hasBeenResolved()
    {
        foreach ($this->resolved as $typeHasBeenResolved) {
            if ($typeHasBeenResolved === \false) {
                return \false;
            }
        }
        return \true;
    }
    /**
     * Mixes an array of IP addresses into the connect queue in such a way they alternate when attempting to connect.
     * The goal behind it is first attempt to connect to IPv6, then to IPv4, then to IPv6 again until one of those
     * attempts succeeds.
     *
     * @link https://tools.ietf.org/html/rfc8305#section-4
     *
     * @internal
     */
    public function mixIpsIntoConnectQueue(array $ips)
    {
        $this->ipsCount += \count($ips);
        $connectQueueStash = $this->connectQueue;
        $this->connectQueue = array();
        while (\count($connectQueueStash) > 0 || \count($ips) > 0) {
            if (\count($ips) > 0) {
                $this->connectQueue[] = \array_shift($ips);
            }
            if (\count($connectQueueStash) > 0) {
                $this->connectQueue[] = \array_shift($connectQueueStash);
            }
        }
    }
    /**
     * @internal
     * @return string
     */
    public function error()
    {
        if ($this->lastError4 === $this->lastError6) {
            $message = $this->lastError6;
        } elseif ($this->lastErrorFamily === 6) {
            $message = 'Last error for IPv6: ' . $this->lastError6 . '. Previous error for IPv4: ' . $this->lastError4;
        } else {
            $message = 'Last error for IPv4: ' . $this->lastError4 . '. Previous error for IPv6: ' . $this->lastError6;
        }
        if ($this->hasBeenResolved() && $this->ipsCount === 0) {
            if ($this->lastError6 === $this->lastError4) {
                $message = ' during DNS lookup: ' . $this->lastError6;
            } else {
                $message = ' during DNS lookup. ' . $message;
            }
        } else {
            $message = ': ' . $message;
        }
        return 'Connection to ' . $this->uri . ' failed' . $message;
    }
}
