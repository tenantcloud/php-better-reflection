<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param array-key $key
 */
function keyNotExists(array $array, $key) : array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::keyNotExists($array, $key);
    return $array;
}
/**
 * @psalm-pure
 *
 * @param array-key $key
 */
function nullOrKeyNotExists(?array $array, $key) : ?array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrKeyNotExists($array, $key);
    return $array;
}
/**
 * @psalm-pure
 *
 * @param iterable<array> $array
 * @param array-key $key
 *
 * @return iterable<array>
 */
function allKeyNotExists(iterable $array, $key) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allKeyNotExists($array, $key);
    return $array;
}
