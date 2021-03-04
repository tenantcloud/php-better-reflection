<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Analyser\Bug3142;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class ParentClass
{
    /**
     * @return int
     */
    public function sayHi()
    {
        return 'hi';
    }
}
/**
 * @method string sayHi()
 * @method string sayHello()
 */
class HelloWorld extends \TenantCloud\BetterReflection\Relocated\Analyser\Bug3142\ParentClass
{
    /**
     * @return int
     */
    public function sayHello()
    {
        return 'hello';
    }
}
function () : void {
    $hw = new \TenantCloud\BetterReflection\Relocated\Analyser\Bug3142\HelloWorld();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $hw->sayHi());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $hw->sayHello());
};
interface DecoratorInterface
{
}
class FooDecorator implements \TenantCloud\BetterReflection\Relocated\Analyser\Bug3142\DecoratorInterface
{
    public function getCode() : string
    {
        return 'FOO';
    }
}
trait DecoratorTrait
{
    public function getDecorator() : \TenantCloud\BetterReflection\Relocated\Analyser\Bug3142\DecoratorInterface
    {
        return new \TenantCloud\BetterReflection\Relocated\Analyser\Bug3142\FooDecorator();
    }
}
/**
 * @method FooDecorator getDecorator()
 */
class Dummy
{
    use DecoratorTrait;
    public function getLabel() : string
    {
        return $this->getDecorator()->getCode();
    }
}
function () {
    $dummy = new \TenantCloud\BetterReflection\Relocated\Analyser\Bug3142\Dummy();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Analyser\Bug3142\FooDecorator::class, $dummy->getDecorator());
};
