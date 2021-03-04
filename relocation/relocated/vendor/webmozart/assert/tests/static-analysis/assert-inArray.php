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
function inArray($value, array $values)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::inArray($value, $values);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function nullOrInArray($value, array $values)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrInArray($value, $values);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function allInArray($value, array $values)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allInArray($value, $values);
    return $value;
}
