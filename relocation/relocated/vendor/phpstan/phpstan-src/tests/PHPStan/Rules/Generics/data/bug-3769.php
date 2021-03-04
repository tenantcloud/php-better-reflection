<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3769;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @template K of array-key
 * @param array<K, int> $in
 * @return array<K, string>
 */
function stringValues(array $in) : array
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<K of (int|string) (function Bug3769\\stringValues(), argument), int>', $in);
    return \array_map(function (int $int) : string {
        return (string) $int;
    }, $in);
}
/**
 * @param array<int, int> $foo
 * @param array<string, int> $bar
 * @param array<int> $baz
 */
function foo(array $foo, array $bar, array $baz) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', stringValues($foo));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, string>', stringValues($bar));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>', stringValues($baz));
}
/**
 * @template T of \stdClass|\Exception
 * @param T $foo
 */
function fooUnion($foo) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of Exception|stdClass (function Bug3769\\fooUnion(), argument)', $foo);
}
