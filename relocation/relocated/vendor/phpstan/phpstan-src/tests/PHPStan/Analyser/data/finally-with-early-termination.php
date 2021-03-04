<?php

namespace TenantCloud\BetterReflection\Relocated\FinallyNamespace;

try {
    $integerOrString = 1;
    $fooOrBarException = null;
    return 1;
} catch (\TenantCloud\BetterReflection\Relocated\FinallyNamespace\FooException $e) {
    $integerOrString = 1;
    $fooOrBarException = $e;
    throw $e;
} catch (\TenantCloud\BetterReflection\Relocated\FinallyNamespace\BarException $e) {
    $integerOrString = 'foo';
    $fooOrBarException = $e;
    return $e;
} finally {
    die;
}
