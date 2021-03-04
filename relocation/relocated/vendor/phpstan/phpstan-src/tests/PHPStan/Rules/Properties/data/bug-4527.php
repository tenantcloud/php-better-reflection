<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\Bug4527;

class Foo
{
    /**
     * @param Bar[] $bars
     */
    public function foo(array $bars) : void
    {
        ($bars['randomKey'] ?? null)?->bar;
    }
}
class Bar
{
    public $bar;
}
