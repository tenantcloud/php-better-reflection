<?php

namespace TenantCloud\BetterReflection\Relocated\RingCentral\Psr7;

use TenantCloud\BetterReflection\Relocated\Psr\Http\Message\StreamInterface;
/**
 * Stream decorator that prevents a stream from being seeked
 */
class NoSeekStream extends \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\StreamDecoratorTrait implements \TenantCloud\BetterReflection\Relocated\Psr\Http\Message\StreamInterface
{
    public function seek($offset, $whence = \SEEK_SET)
    {
        throw new \RuntimeException('Cannot seek a NoSeekStream');
    }
    public function isSeekable()
    {
        return \false;
    }
}
