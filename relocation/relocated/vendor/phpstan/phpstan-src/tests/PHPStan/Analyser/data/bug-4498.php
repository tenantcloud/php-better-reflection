<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4498;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param iterable<TKey, TValue> $iterable
     *
     * @return iterable<TKey, TValue>
     *
     * @template TKey
     * @template TValue
     */
    public function fcn(iterable $iterable) : iterable
    {
        if ($iterable instanceof \Traversable) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('iterable<TKey (method Bug4498\\Foo::fcn(), argument), TValue (method Bug4498\\Foo::fcn(), argument)>&Traversable', $iterable);
            return $iterable;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<TKey (method Bug4498\\Foo::fcn(), argument), TValue (method Bug4498\\Foo::fcn(), argument)>', $iterable);
        return $iterable;
    }
    /**
     * @param iterable<TKey, TValue> $iterable
     *
     * @return iterable<TKey, TValue>
     *
     * @template TKey
     * @template TValue
     */
    public function bar(iterable $iterable) : iterable
    {
        if (\is_array($iterable)) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<TKey (method Bug4498\\Foo::bar(), argument), TValue (method Bug4498\\Foo::bar(), argument)>', $iterable);
            return $iterable;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Traversable<TKey (method Bug4498\\Foo::bar(), argument), TValue (method Bug4498\\Foo::bar(), argument)>', $iterable);
        return $iterable;
    }
}
