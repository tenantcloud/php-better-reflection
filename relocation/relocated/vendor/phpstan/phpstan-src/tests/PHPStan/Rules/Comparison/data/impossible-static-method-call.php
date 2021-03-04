<?php

namespace TenantCloud\BetterReflection\Relocated\ImpossibleStaticMethodCall;

class Foo
{
    public function doFoo(int $foo, string $bar)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClass::assertInt($foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClass::assertInt($bar);
    }
    /**
     * @param string|int $bar
     */
    public function doBar($bar)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClass::assertInt($bar);
    }
    public function doBaz(int $foo, string $bar)
    {
        $assertion = new \TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClass();
        $assertion::assertInt($foo);
        $assertion::assertInt($bar);
        $assertion::assertInt(1, 2);
        $assertion::assertInt(1, 2, 3);
    }
    public function doPhpunit()
    {
        \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\Assert::assertSame(200, $this->nullableInt());
        \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\Assert::assertSame(302, $this->nullableInt());
        \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\Assert::assertSame(200, $this->nullableInt());
    }
    public function doPhpunitNot()
    {
        \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\Assert::assertSame(200, $this->nullableInt());
        \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\Assert::assertNotSame(302, $this->nullableInt());
    }
    public function nullableInt() : ?int
    {
    }
}
