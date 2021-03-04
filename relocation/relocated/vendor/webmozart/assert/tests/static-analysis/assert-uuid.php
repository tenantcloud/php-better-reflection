<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 */
function uuid(string $value) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::uuid($value);
    return $value;
}
/**
 * @psalm-pure
 */
function nullOrUuid(?string $value) : ?string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrUuid($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<string> $value
 *
 * @return iterable<string>
 */
function allUuid(iterable $value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allUuid($value);
    return $value;
}
