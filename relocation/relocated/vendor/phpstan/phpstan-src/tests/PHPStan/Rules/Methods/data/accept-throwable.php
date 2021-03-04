<?php

namespace TenantCloud\BetterReflection\Relocated\AcceptThrowable;

interface SomeInterface
{
}
interface InterfaceExtendingThrowable extends \Throwable
{
}
class NonExceptionClass
{
}
class Foo
{
    public function doFoo(\Throwable $e)
    {
    }
    public function doBar(int $i)
    {
    }
}
function () {
    $foo = new \TenantCloud\BetterReflection\Relocated\AcceptThrowable\Foo();
    try {
    } catch (\TenantCloud\BetterReflection\Relocated\AcceptThrowable\SomeInterface $e) {
        $foo->doFoo($e);
        $foo->doBar($e);
    } catch (\TenantCloud\BetterReflection\Relocated\AcceptThrowable\InterfaceExtendingThrowable $e) {
        $foo->doFoo($e);
        $foo->doBar($e);
    } catch (\TenantCloud\BetterReflection\Relocated\AcceptThrowable\NonExceptionClass $e) {
        $foo->doFoo($e);
        // fine, the feasibility must be checked by a different rule
        $foo->doBar($e);
    } catch (\Exception $e) {
        $foo->doFoo($e);
        $foo->doBar($e);
    }
};
