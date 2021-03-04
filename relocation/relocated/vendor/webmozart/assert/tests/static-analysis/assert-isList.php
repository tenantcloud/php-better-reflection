<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return list<mixed>
 */
function isList($value) : array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isList($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param array<\stdClass> $value
 *
 * @return list<\stdClass>
 */
function isListWithKnownType(array $value) : array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isList($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return null|list<mixed>
 */
function nullOrIsList($value) : ?array
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsList($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<list<mixed>>
 */
function allIsList($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsList($value);
    return $value;
}
