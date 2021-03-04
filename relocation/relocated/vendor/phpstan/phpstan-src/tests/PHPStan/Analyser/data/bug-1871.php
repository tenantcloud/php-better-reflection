<?php

namespace TenantCloud\BetterReflection\Relocated\Bug1871;

interface I
{
}
class A implements \TenantCloud\BetterReflection\Relocated\Bug1871\I
{
}
function () : void {
    $objects = [new \TenantCloud\BetterReflection\Relocated\Bug1871\A()];
    foreach ($objects as $object) {
        \var_dump(\is_subclass_of($object, 'TenantCloud\\BetterReflection\\Relocated\\C'));
    }
};
