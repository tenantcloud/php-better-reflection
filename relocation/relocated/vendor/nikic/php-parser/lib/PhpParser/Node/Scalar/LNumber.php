<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar;

use TenantCloud\BetterReflection\Relocated\PhpParser\Error;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar;
class LNumber extends \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar
{
    /* For use in "kind" attribute */
    const KIND_BIN = 2;
    const KIND_OCT = 8;
    const KIND_DEC = 10;
    const KIND_HEX = 16;
    /** @var int Number value */
    public $value;
    /**
     * Constructs an integer number scalar node.
     *
     * @param int   $value      Value of the number
     * @param array $attributes Additional attributes
     */
    public function __construct(int $value, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->value = $value;
    }
    public function getSubNodeNames() : array
    {
        return ['value'];
    }
    /**
     * Constructs an LNumber node from a string number literal.
     *
     * @param string $str               String number literal (decimal, octal, hex or binary)
     * @param array  $attributes        Additional attributes
     * @param bool   $allowInvalidOctal Whether to allow invalid octal numbers (PHP 5)
     *
     * @return LNumber The constructed LNumber, including kind attribute
     */
    public static function fromString(string $str, array $attributes = [], bool $allowInvalidOctal = \false) : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber
    {
        $str = \str_replace('_', '', $str);
        if ('0' !== $str[0] || '0' === $str) {
            $attributes['kind'] = \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber::KIND_DEC;
            return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber((int) $str, $attributes);
        }
        if ('x' === $str[1] || 'X' === $str[1]) {
            $attributes['kind'] = \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber::KIND_HEX;
            return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber(\hexdec($str), $attributes);
        }
        if ('b' === $str[1] || 'B' === $str[1]) {
            $attributes['kind'] = \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber::KIND_BIN;
            return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber(\bindec($str), $attributes);
        }
        if (!$allowInvalidOctal && \strpbrk($str, '89')) {
            throw new \TenantCloud\BetterReflection\Relocated\PhpParser\Error('Invalid numeric literal', $attributes);
        }
        // use intval instead of octdec to get proper cutting behavior with malformed numbers
        $attributes['kind'] = \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber::KIND_OCT;
        return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber(\intval($str, 8), $attributes);
    }
    public function getType() : string
    {
        return 'Scalar_LNumber';
    }
}
