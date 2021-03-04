<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3321;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/** @template T */
interface Container
{
    /** @return T */
    public function get();
}
class Foo
{
    /**
     * @template T
     * @param array<Container<T>> $containers
     * @return T
     */
    function unwrap(array $containers)
    {
        return \array_map(function ($container) {
            return $container->get();
        }, $containers)[0];
    }
    /**
     * @param array<Container<int>> $typed_containers
     */
    function takesDifferentTypes(array $typed_containers) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $this->unwrap($typed_containers));
    }
}
/**
 * @template TFacade of Facade
 */
interface Facadable
{
}
/**
 * @implements Facadable<AFacade>
 */
class A implements \TenantCloud\BetterReflection\Relocated\Bug3321\Facadable
{
}
/**
 * @implements Facadable<BFacade>
 */
class B implements \TenantCloud\BetterReflection\Relocated\Bug3321\Facadable
{
}
abstract class Facade
{
}
class AFacade extends \TenantCloud\BetterReflection\Relocated\Bug3321\Facade
{
}
class BFacade extends \TenantCloud\BetterReflection\Relocated\Bug3321\Facade
{
}
class FacadeFactory
{
    /**
     * @template TFacade of Facade
     * @param class-string<Facadable<TFacade>> $class
     * @return TFacade
     */
    public function create(string $class) : \TenantCloud\BetterReflection\Relocated\Bug3321\Facade
    {
        // Returns facade for class
    }
}
function (\TenantCloud\BetterReflection\Relocated\Bug3321\FacadeFactory $f) : void {
    $facadeA = $f->create(\TenantCloud\BetterReflection\Relocated\Bug3321\A::class);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug3321\AFacade::class, $facadeA);
};
