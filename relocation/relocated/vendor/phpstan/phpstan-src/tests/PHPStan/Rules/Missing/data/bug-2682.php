<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2682;

class HelloWorld
{
    public function sayHello() : void
    {
        function (array $array) {
            function () : string {
                return 'abc';
            };
        };
    }
}
