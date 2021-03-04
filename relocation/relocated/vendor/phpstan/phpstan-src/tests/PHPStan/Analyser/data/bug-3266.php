<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3266;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @phpstan-template TKey
     * @phpstan-template TValue
     * @phpstan-param  array<TKey, TValue>  $iterator
     * @phpstan-return array<TKey, TValue>
     */
    public function iteratorToArray($iterator)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<TKey (method Bug3266\\Foo::iteratorToArray(), argument), TValue (method Bug3266\\Foo::iteratorToArray(), argument)>', $iterator);
        $array = [];
        foreach ($iterator as $key => $value) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TKey (method Bug3266\\Foo::iteratorToArray(), argument)', $key);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TValue (method Bug3266\\Foo::iteratorToArray(), argument)', $value);
            $array[$key] = $value;
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<TKey (method Bug3266\\Foo::iteratorToArray(), argument), TValue (method Bug3266\\Foo::iteratorToArray(), argument)>&nonEmpty', $array);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<TKey (method Bug3266\\Foo::iteratorToArray(), argument), TValue (method Bug3266\\Foo::iteratorToArray(), argument)>', $array);
        return $array;
    }
}
