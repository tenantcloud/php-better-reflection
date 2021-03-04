<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4557;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Lorem
{
}
class Ipsum extends \TenantCloud\BetterReflection\Relocated\Bug4557\Lorem
{
}
interface MockObject
{
}
class Foo
{
    /**
     * @template T
     * @param class-string<T> $class
     * @return T&MockObject
     */
    public function createMock($class)
    {
    }
}
/**
 * @template T of Lorem
 */
class Bar extends \TenantCloud\BetterReflection\Relocated\Bug4557\Foo
{
    public function doBar() : void
    {
        $mock = $this->createMock(\stdClass::class);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug4557\\MockObject&stdClass', $mock);
    }
    /** @return T */
    public function doBaz()
    {
    }
}
class Baz
{
    /**
     * @param Bar<Lorem> $barLorem
     * @param Bar<Ipsum> $barIpsum
     */
    public function doFoo(\TenantCloud\BetterReflection\Relocated\Bug4557\Bar $barLorem, \TenantCloud\BetterReflection\Relocated\Bug4557\Bar $barIpsum) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4557\\Lorem', $barLorem->doBaz());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4557\\Ipsum', $barIpsum->doBaz());
    }
}
