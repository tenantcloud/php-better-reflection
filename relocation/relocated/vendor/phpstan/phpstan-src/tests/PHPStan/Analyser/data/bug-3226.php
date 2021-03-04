<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3226;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @var class-string
     */
    private $class;
    /**
     * @param class-string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }
    /**
     * @return class-string
     */
    public function __toString() : string
    {
        return $this->class;
    }
}
function (\TenantCloud\BetterReflection\Relocated\Bug3226\Foo $foo) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string', $foo->__toString());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string', (string) $foo);
};
/**
 * @template T
 */
class Bar
{
    /**
     * @var class-string<T>
     */
    private $class;
    /**
     * @param class-string<T> $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }
    /**
     * @return class-string<T>
     */
    public function __toString() : string
    {
        return $this->class;
    }
}
function (\TenantCloud\BetterReflection\Relocated\Bug3226\Bar $bar) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<mixed>', $bar->__toString());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<mixed>', (string) $bar);
};
function () : void {
    $bar = new \TenantCloud\BetterReflection\Relocated\Bug3226\Bar(\Exception::class);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<Exception>', $bar->__toString());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<Exception>', (string) $bar);
};
