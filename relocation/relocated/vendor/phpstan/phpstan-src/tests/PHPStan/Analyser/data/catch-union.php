<?php

namespace TenantCloud\BetterReflection\Relocated\CatchUnion;

class FooException extends \Exception
{
}
class BarException extends \Exception
{
}
function () {
    try {
    } catch (\TenantCloud\BetterReflection\Relocated\CatchUnion\FooException|\TenantCloud\BetterReflection\Relocated\CatchUnion\BarException $e) {
        die;
    }
};
