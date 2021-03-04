<?php

namespace TenantCloud\BetterReflection\Relocated\Generics\Bug2574;

abstract class Model
{
    /** @return static */
    public function newInstance()
    {
        return new static();
    }
}
/**
 * @template T of Model
 * @param T $m
 * @return T
 */
function foo(\TenantCloud\BetterReflection\Relocated\Generics\Bug2574\Model $m) : \TenantCloud\BetterReflection\Relocated\Generics\Bug2574\Model
{
    return $m->newInstance();
}
