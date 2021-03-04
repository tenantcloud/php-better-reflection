<?php

namespace TenantCloud\BetterReflection\Relocated\FinallyNamespace;

class FooException extends \Exception
{
}
class BarException extends \Exception
{
}
function () {
    try {
        $integerOrString = 1;
        $fooOrBarException = null;
    } catch (\TenantCloud\BetterReflection\Relocated\FinallyNamespace\FooException $e) {
        $integerOrString = 1;
        $fooOrBarException = $e;
    } catch (\TenantCloud\BetterReflection\Relocated\FinallyNamespace\BarException $e) {
        $integerOrString = 'foo';
        $fooOrBarException = $e;
    } finally {
        die;
    }
};
