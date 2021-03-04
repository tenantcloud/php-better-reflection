<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param mixed $limit
 *
 * @return mixed
 */
function greaterThanEq($value, $limit)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::greaterThanEq($value, $limit);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param mixed $limit
 *
 * @return mixed
 */
function nullOrGreaterThanEq($value, $limit)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrGreaterThanEq($value, $limit);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param mixed $limit
 *
 * @return mixed
 */
function allGreaterThanEq($value, $limit)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allGreaterThanEq($value, $limit);
    return $value;
}
