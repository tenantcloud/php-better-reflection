<?php

namespace TenantCloud\BetterReflection\Relocated\ConstExprPhpDocType;

use RecursiveIteratorIterator as Rec;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public const SOME_CONSTANT = 1;
    public const SOME_OTHER_CONSTANT = 2;
    /**
     * @param 'foo'|'bar' $one
     * @param self::SOME_* $two
     * @param self::SOME_OTHER_CONSTANT $three
     * @param \ConstExprPhpDocType\Foo::SOME_CONSTANT $four
     * @param Rec::LEAVES_ONLY $five
     * @param 1.0 $six
     * @param 234 $seven
     * @param self::SOME_OTHER_* $eight
     * @param self::* $nine
     */
    public function doFoo($one, $two, $three, $four, $five, $six, $seven, $eight, $nine)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType("'bar'|'foo'", $one);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2', $two);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('2', $three);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $four);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('0', $five);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1.0', $six);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('234', $seven);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('2', $eight);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2', $nine);
    }
}
