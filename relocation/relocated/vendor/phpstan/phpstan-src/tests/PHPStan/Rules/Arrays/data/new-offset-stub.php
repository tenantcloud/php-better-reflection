<?php

namespace TenantCloud\BetterReflection\Relocated\NewOffsetStub;

/**
 * @phpstan-implements \ArrayAccess<int, \stdClass>
 */
abstract class Foo implements \ArrayAccess
{
}
function (\TenantCloud\BetterReflection\Relocated\NewOffsetStub\Foo $foo) : void {
    $foo[] = new \stdClass();
};
