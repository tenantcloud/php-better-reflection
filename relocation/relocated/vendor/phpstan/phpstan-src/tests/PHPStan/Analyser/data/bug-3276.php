<?php

// lint >= 7.4
namespace TenantCloud\BetterReflection\Relocated\Bug3276;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array{name?:string} $settings
     */
    public function doFoo(array $settings) : void
    {
        $settings['name'] ??= 'unknown';
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'name\' => string)', $settings);
    }
    /**
     * @param array{name?:string} $settings
     */
    public function doBar(array $settings) : void
    {
        $settings['name'] = 'unknown';
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'name\' => \'unknown\')', $settings);
    }
}
