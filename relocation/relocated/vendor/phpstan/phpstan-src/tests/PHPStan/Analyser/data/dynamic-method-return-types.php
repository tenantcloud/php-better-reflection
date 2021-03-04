<?php

namespace TenantCloud\BetterReflection\Relocated\DynamicMethodReturnTypesNamespace;

class EntityManager
{
    public function getByPrimary(string $className, int $id) : \TenantCloud\BetterReflection\Relocated\DynamicMethodReturnTypesNamespace\Entity
    {
        return new $className();
    }
    public static function createManagerForEntity(string $className) : self
    {
    }
}
class InheritedEntityManager extends \TenantCloud\BetterReflection\Relocated\DynamicMethodReturnTypesNamespace\EntityManager
{
}
class ComponentContainer implements \ArrayAccess
{
    public function offsetExists($offset)
    {
    }
    public function offsetGet($offset) : \TenantCloud\BetterReflection\Relocated\DynamicMethodReturnTypesNamespace\Entity
    {
    }
    public function offsetSet($offset, $value)
    {
    }
    public function offsetUnset($offset)
    {
    }
}
class Foo
{
    public function __construct()
    {
    }
    public function doFoo()
    {
        $em = new \TenantCloud\BetterReflection\Relocated\DynamicMethodReturnTypesNamespace\EntityManager();
        $iem = new \TenantCloud\BetterReflection\Relocated\DynamicMethodReturnTypesNamespace\InheritedEntityManager();
        $container = new \TenantCloud\BetterReflection\Relocated\DynamicMethodReturnTypesNamespace\ComponentContainer();
        die;
    }
}
class FooWithoutConstructor
{
}
