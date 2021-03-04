<?php

namespace TenantCloud\BetterReflection\Relocated\DeclarationWarning;

@\mkdir('/foo/bar');
require __DIR__ . '/trigger-warning.php';
class Foo
{
    public function doFoo() : void
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\DeclarationWarning\Foo
{
    public function doFoo(int $i) : void
    {
    }
}
