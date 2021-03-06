<?php

namespace TenantCloud\BetterReflection\Relocated\Levels\Comparison;

class Foo
{
    private const FOO_CONST = 'foo';
    /**
     * @param \stdClass $object
     * @param int $int
     * @param float $float
     * @param string $string
     * @param int|string $intOrString
     * @param int|\stdClass $intOrObject
     */
    public function doFoo(\stdClass $object, int $int, float $float, string $string, $intOrString, $intOrObject)
    {
        $object == $int;
        $object == $float;
        $object == $string;
        $object == $intOrString;
        $object == $intOrObject;
        self::FOO_CONST === 'bar';
    }
    public function doBar(\ffmpeg_movie $movie) : void
    {
        $movie->getArtist() === 1;
    }
}
