<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4504;

class Foo
{
    public function sayHello($models) : void
    {
        /** @var \Iterator<A> $models */
        foreach ($models as $k => $v) {
        }
    }
}
