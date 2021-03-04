<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
function uniqueValues(array $values) : array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::uniqueValues($values);
    return $values;
}
function nullOrUniqueValues(?array $values) : ?array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrUniqueValues($values);
    return $values;
}
/**
 * @param iterable<array> $values
 *
 * @return iterable<array>
 */
function allUniqueValues(iterable $values) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allUniqueValues($values);
    return $values;
}
