<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3608;

interface IHost
{
    /** @return IHost[] * */
    public static function getArray();
}
class MyHost implements \TenantCloud\BetterReflection\Relocated\Bug3608\IHost
{
    public static function getArray()
    {
        return [new self()];
    }
}
class HelloWorld
{
    /**
     * @param class-string<IHost> $name
     **/
    public function getConfig(string $name) : void
    {
        \call_user_func([$name, 'getArray']);
    }
}
