<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2268;

abstract class Message implements \ArrayAccess
{
    /**
     * @param string $value
     */
    public abstract function offsetSet($key, $value);
}
function test(\TenantCloud\BetterReflection\Relocated\Bug2268\Message $data)
{
    if (isset($data['name'])) {
        $data['name'] = 1;
    }
    test($data);
}
