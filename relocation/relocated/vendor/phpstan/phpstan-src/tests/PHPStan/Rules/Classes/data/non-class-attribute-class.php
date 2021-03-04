<?php

namespace TenantCloud\BetterReflection\Relocated\NonClassAttributeClass;

#[\Attribute]
interface Foo
{
}
#[\Attribute]
trait Bar
{
}
#[\Attribute]
class Baz
{
}
#[\Attribute]
abstract class Lorem
{
}
#[\Attribute]
class Ipsum
{
    private function __construct()
    {
    }
}
