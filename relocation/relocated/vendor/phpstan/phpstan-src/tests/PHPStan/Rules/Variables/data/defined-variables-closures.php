<?php

namespace TenantCloud\BetterReflection\Relocated\DefinedVariablesClosures;

class Foo
{
    public function doFoo()
    {
        function () {
            \var_dump($this);
        };
        static function () {
            \var_dump($this);
        };
    }
}
