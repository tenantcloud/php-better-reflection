<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return non-empty-array<string, mixed>
 */
function isNonEmptyMap($value) : array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isNonEmptyMap($value);
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
function isNonEmptyMapWithKnownType(array $value) : array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isNonEmptyMap($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function nullOrIsNonEmptyMap($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsNonEmptyMap($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<mixed|array<mixed>> $value
 *
 * @return iterable<mixed|array<mixed>>
 */
function allIsNonEmptyMap(iterable $value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsNonEmptyMap($value);
    return $value;
}
