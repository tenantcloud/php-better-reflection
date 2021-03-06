<?php

namespace TenantCloud\BetterReflection\Relocated\AccessPropertiesAfterIsNull;

class Foo
{
    /** @var self|null */
    private $fooProperty;
    /**
     * @param self|null $foo
     */
    public function doFoo($foo)
    {
        if (\is_null($foo) && $foo->fooProperty) {
        }
        if (\is_null($foo) || $foo->fooProperty) {
        }
        if (!\is_null($foo) && $foo->fooProperty) {
        }
        if (!\is_null($foo) || $foo->fooProperty) {
        }
        if (\is_null($foo) || $foo->barProperty) {
        }
        if (!\is_null($foo) && $foo->barProperty) {
        }
        while (\is_null($foo) && $foo->fooProperty) {
        }
        while (\is_null($foo) || $foo->fooProperty) {
        }
        while (!\is_null($foo) && $foo->fooProperty) {
        }
        while (!\is_null($foo) || $foo->fooProperty) {
        }
        while (\is_null($foo) || $foo->barProperty) {
        }
        while (!\is_null($foo) && $foo->barProperty) {
        }
    }
}
