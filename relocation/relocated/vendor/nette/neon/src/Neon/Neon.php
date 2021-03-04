<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\Neon;

/**
 * Simple parser & generator for Nette Object Notation.
 * @see https://ne-on.org
 */
final class Neon
{
    public const BLOCK = \TenantCloud\BetterReflection\Relocated\Nette\Neon\Encoder::BLOCK;
    public const CHAIN = '!!chain';
    /**
     * Returns value converted to NEON. The flag can be Neon::BLOCK, which will create multiline output.
     */
    public static function encode($value, int $flags = 0) : string
    {
        $encoder = new \TenantCloud\BetterReflection\Relocated\Nette\Neon\Encoder();
        return $encoder->encode($value, $flags);
    }
    /**
     * Converts given NEON to PHP value.
     * Returns scalars, arrays, DateTimeImmutable and Entity objects.
     * @return mixed
     */
    public static function decode(string $input)
    {
        $decoder = new \TenantCloud\BetterReflection\Relocated\Nette\Neon\Decoder();
        return $decoder->decode($input);
    }
}