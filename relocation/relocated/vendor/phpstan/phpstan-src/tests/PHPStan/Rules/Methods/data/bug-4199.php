<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\Bug4199;

class Foo
{
    public function getBar() : ?\TenantCloud\BetterReflection\Relocated\Bug4199\Bar
    {
        return null;
    }
}
class Bar
{
    public function getBaz() : \TenantCloud\BetterReflection\Relocated\Bug4199\Baz
    {
        return new \TenantCloud\BetterReflection\Relocated\Bug4199\Baz();
    }
    public function getBazOrNull() : ?\TenantCloud\BetterReflection\Relocated\Bug4199\Baz
    {
        return null;
    }
}
class Baz
{
    public function answer() : int
    {
        return 42;
    }
}
function () : void {
    $foo = new \TenantCloud\BetterReflection\Relocated\Bug4199\Foo();
    $answer = $foo->getBar()?->getBaz()->answer();
    $answer2 = $foo->getBar()?->getBazOrNull()->answer();
};
