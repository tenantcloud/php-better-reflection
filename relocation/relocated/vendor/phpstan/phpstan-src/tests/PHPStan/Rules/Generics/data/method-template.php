<?php

namespace TenantCloud\BetterReflection\Relocated\MethodTemplateType;

class Foo
{
    /**
     * @template stdClass
     */
    public function doFoo()
    {
    }
    /**
     * @template T of Zazzzu
     */
    public function doBar()
    {
    }
}
/**
 * @template T of \Exception
 * @template Z
 */
class Bar
{
    /**
     * @template T
     * @template U
     */
    public function doFoo()
    {
    }
}
class Baz
{
    /**
     * @template T of int
     */
    public function doFoo()
    {
    }
}
class Lorem
{
    /**
     * @template TypeAlias
     */
    public function doFoo()
    {
    }
}
