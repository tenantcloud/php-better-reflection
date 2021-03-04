<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3991;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param \stdClass|array|null $config
     *
     * @return \stdClass
     */
    public static function email($config = null)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $config);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array|stdClass|null', $config);
        if (empty($config)) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $config);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array|stdClass|null', $config);
            $config = new \stdClass();
        } elseif (!(\is_array($config) || $config instanceof \stdClass)) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed~array|stdClass|false|null', $config);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $config);
        }
        return new \stdClass($config);
    }
}
