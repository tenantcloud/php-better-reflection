<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3132;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use const ARRAY_FILTER_USE_BOTH;
class Foo
{
    /**
     * @param array<string,object> $objects
     *
     * @return array<string,object>
     */
    function filter(array $objects) : array
    {
        return \array_filter($objects, static function ($key) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $key);
        }, \ARRAY_FILTER_USE_KEY);
    }
    /**
     * @param array<string,object> $objects
     *
     * @return array<string,object>
     */
    function bar(array $objects) : array
    {
        return \array_filter($objects, static function ($val) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $val);
        });
    }
    /**
     * @param array<string,object> $objects
     *
     * @return array<string,object>
     */
    function baz(array $objects) : array
    {
        return \array_filter($objects, static function ($val, $key) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $key);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $val);
        }, \ARRAY_FILTER_USE_BOTH);
    }
}
