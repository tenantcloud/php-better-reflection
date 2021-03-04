<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param array-key $key
 */
function keyExists(array $array, $key) : array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::keyExists($array, $key);
    return $array;
}
/**
 * @psalm-pure
 *
 * @param array-key $key
 */
function nullOrKeyExists(?array $array, $key) : ?array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrKeyExists($array, $key);
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
function allKeyExists(iterable $array, $key) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allKeyExists($array, $key);
    return $array;
}
