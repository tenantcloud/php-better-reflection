<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3994;

class HelloWorld
{
    public function split(string $str) : void
    {
        $parts = \explode(".", $str);
        \assert(\count($parts) === 4);
    }
}
