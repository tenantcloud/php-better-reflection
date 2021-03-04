<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return non-empty-list<mixed>
 */
function isNonEmptyList($value) : array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isNonEmptyList($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return null|non-empty-list<mixed>
 */
function nullOrIsNonEmptyList($value) : ?array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsNonEmptyList($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<non-empty-list<mixed>>
 */
function allIsNonEmptyList($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsNonEmptyList($value);
    return $value;
}
