<?php

namespace TenantCloud\BetterReflection\Relocated\RingCentral\Psr7;

use TenantCloud\BetterReflection\Relocated\Psr\Http\Message\StreamInterface;
/**
 * Stream decorator that begins dropping data once the size of the underlying
 * stream becomes too full.
 */
class DroppingStream extends \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\StreamDecoratorTrait implements \TenantCloud\BetterReflection\Relocated\Psr\Http\Message\StreamInterface
{
    private $maxLength;
    /**
     * @param StreamInterface $stream    Underlying stream to decorate.
     * @param int             $maxLength Maximum size before dropping data.
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\Psr\Http\Message\StreamInterface $stream, $maxLength)
    {
        parent::__construct($stream);
        $this->maxLength = $maxLength;
    }
    public function write($string)
    {
        $diff = $this->maxLength - $this->stream->getSize();
        // Begin returning 0 when the underlying stream is too large.
        if ($diff <= 0) {
            return 0;
        }
        // Write the stream or a subset of the stream if needed.
        if (\strlen($string) < $diff) {
            return $this->stream->write($string);
        }
        return $this->stream->write(\substr($string, 0, $diff));
    }
}
