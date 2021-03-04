<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function oneOf($value, array $values)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::oneOf($value, $values);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function nullOrOneOf($value, array $values)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrOneOf($value, $values);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function allOneOf($value, array $values)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allOneOf($value, $values);
    return $value;
}
