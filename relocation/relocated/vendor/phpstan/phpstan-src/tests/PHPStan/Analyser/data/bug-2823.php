<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Bug2823;

class Foo
{
    public function sayHello() : void
    {
        \var_dump(new \LevelDB("./somedir"));
    }
}
