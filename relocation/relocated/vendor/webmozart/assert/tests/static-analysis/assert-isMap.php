<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return array<string, mixed>
 */
function isMap($value) : array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isMap($value);
    return $value;
}
/**
 * Verifying that the type of the elements in the array is preserved by the assertion
 *
 * @psalm-pure
 *
 * @param array<int|string, \stdClass> $value
 *
 * @return array<string, \stdClass>
 */
function isMapWithKnownType(array $value) : array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isMap($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param array<int|string, mixed> $value
 *
 * @return array<empty, empty>
 */
function isMapWithEmptyArray(array $value) : array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isMap($value);
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isEmpty($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return null|array<string, mixed>
 */
function nullOrIsMap($value) : ?array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsMap($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<mixed|array<mixed>> $value
 *
 * @return iterable<array<string, mixed>>
 */
function allIsMap(iterable $value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsMap($value);
    return $value;
}
