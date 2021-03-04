<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4099;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array{key: array{inner: mixed}} $arr
     */
    function arrayHint(array $arr) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'key\' => array(\'inner\' => mixed))', $arr);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('array', $arr);
        if (!\array_key_exists('key', $arr)) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $arr);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('array', $arr);
            throw new \Exception('no key "key" found.');
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'key\' => array(\'inner\' => mixed))', $arr);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('array&hasOffset(\'key\')', $arr);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'inner\' => mixed)', $arr['key']);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $arr['key']);
        if (!\array_key_exists('inner', $arr['key'])) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'key\' => *NEVER*)', $arr);
            //assertNativeType('array(\'key\' => mixed)', $arr);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $arr['key']);
            //assertNativeType('mixed', $arr['key']);
            throw new \Exception('need key.inner');
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'key\' => array(\'inner\' => mixed))', $arr);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('array(\'key\' => array(\'inner\' => mixed))', $arr);
    }
}
