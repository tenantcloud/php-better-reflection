<?php

namespace TenantCloud\BetterReflection\Relocated\TypeElimination;

class Foo
{
    /** @var Bar|null */
    private $bar;
    public function getValue() : string
    {
    }
    public function test()
    {
        /** @var Foo|null $foo */
        $foo = doFoo();
        if ($foo === null) {
            'nullForSure';
        }
        if ($foo !== null) {
            'notNullForSure';
        }
        if ($foo) {
            'notNullForSure2';
        } else {
            'nullForSure2';
        }
        if (!$foo) {
            'nullForSure3';
        } else {
            'notNullForSure3';
        }
        if (!$this->bar) {
            'propertyNullForSure';
        } else {
            'propertyNotNullForSure';
        }
        if (null === $foo) {
            'yodaNullForSure';
        }
        if (null !== $foo) {
            'yodaNotNullForSure';
        }
        /** @var int|false $intOrFalse */
        $intOrFalse = doFoo();
        if ($intOrFalse === \false) {
            'falseForSure';
        }
        if ($intOrFalse !== \false) {
            'intForSure';
        }
        if (\false === $intOrFalse) {
            'yodaFalseForSure';
        }
        if (\false !== $intOrFalse) {
            'yodaIntForSure';
        }
        if (!\is_bool($intOrFalse)) {
            'yetAnotherIntForSure';
        }
        /** @var int|true $intOrTrue */
        $intOrTrue = doFoo();
        if ($intOrTrue === \true) {
            'trueForSure';
        }
        if ($intOrTrue !== \true) {
            'anotherIntForSure';
        }
        if (\true === $intOrTrue) {
            'yodaTrueForSure';
        }
        if (\true !== $intOrTrue) {
            'yodaAnotherIntForSure';
        }
        if (!\is_bool($intOrTrue)) {
            'yetYetAnotherIntForSure';
        }
        /** @var Foo|Bar|Baz $fooOrBarOrBaz */
        $fooOrBarOrBaz = doFoo();
        if ($fooOrBarOrBaz instanceof \TenantCloud\BetterReflection\Relocated\TypeElimination\Foo) {
            'fooForSure';
        } else {
            'barOrBazForSure';
        }
        if ($fooOrBarOrBaz instanceof \TenantCloud\BetterReflection\Relocated\TypeElimination\Foo) {
            // already tested
        } elseif ($fooOrBarOrBaz instanceof \TenantCloud\BetterReflection\Relocated\TypeElimination\Bar) {
            'barForSure';
        } else {
            'bazForSure';
        }
        if (!$fooOrBarOrBaz instanceof \TenantCloud\BetterReflection\Relocated\TypeElimination\Foo) {
            'anotherBarOrBazForSure';
        } else {
            'anotherFooForSure';
        }
        /** @var Foo|string|null $value */
        $value = doFoo();
        $result = $value instanceof \TenantCloud\BetterReflection\Relocated\TypeElimination\Foo ? $value->getValue() : $value;
        'stringOrNullForSure';
        /** @var Foo|string|null $fooOrStringOrNull */
        $fooOrStringOrNull = doFoo();
        if ($fooOrStringOrNull === null || $fooOrStringOrNull instanceof \TenantCloud\BetterReflection\Relocated\TypeElimination\Foo) {
            'fooOrNull';
            return;
        } else {
            'stringForSure';
        }
        'anotherStringForSure';
    }
}
