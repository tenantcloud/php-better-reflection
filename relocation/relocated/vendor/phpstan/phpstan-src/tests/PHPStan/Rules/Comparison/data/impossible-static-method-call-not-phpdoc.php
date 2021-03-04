<?php

namespace TenantCloud\BetterReflection\Relocated\ImpossibleStaticMethodCallNotPhpDoc;

class Foo
{
    /**
     * @param int $phpDocInt
     */
    public function doFoo(int $realInt, $phpDocInt)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClass::assertInt($realInt);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClass::assertInt($phpDocInt);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClass::assertInt($phpDocInt);
    }
}
