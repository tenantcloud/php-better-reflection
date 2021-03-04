<?php

namespace TenantCloud\BetterReflection\Relocated\TraitUseCase;

trait FooTrait
{
}
class Foo
{
    use FOOTrait;
}
class Bar
{
    use FooTrait;
}
