<?php

namespace TenantCloud\BetterReflection\Relocated\ImpossibleMethodCallNotPhpDoc;

class Foo
{
    /**
     * @param string $phpDocString
     */
    public function doFoo(string $realString, $phpDocString)
    {
        $assertion = new \TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClass();
        $assertion->assertString($realString);
        $assertion->assertString($phpDocString);
        $assertion->assertString($phpDocString);
    }
}
