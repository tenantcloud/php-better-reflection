<?php

namespace TenantCloud\BetterReflection\Relocated\InterfaceExtendsError;

interface Foo extends \TenantCloud\BetterReflection\Relocated\InterfaceExtendsError\Bar
{
}
class BazClass
{
}
interface Lorem extends \TenantCloud\BetterReflection\Relocated\InterfaceExtendsError\BazClass
{
}
trait DolorTrait
{
}
interface Ipsum extends \TenantCloud\BetterReflection\Relocated\InterfaceExtendsError\DolorTrait
{
}
