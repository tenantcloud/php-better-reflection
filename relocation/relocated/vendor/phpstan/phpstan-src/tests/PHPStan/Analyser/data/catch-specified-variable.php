<?php

namespace TenantCloud\BetterReflection\Relocated\TryCatchWithSpecifiedVariable;

class FooException extends \Exception
{
}
function () {
    /** @var string|null $foo */
    $foo = doFoo();
    if ($foo !== null) {
        return;
    }
    try {
    } catch (\TenantCloud\BetterReflection\Relocated\TryCatchWithSpecifiedVariable\FooException $foo) {
        die;
    }
};
