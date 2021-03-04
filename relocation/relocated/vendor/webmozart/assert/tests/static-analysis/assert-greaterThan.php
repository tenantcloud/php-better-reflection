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
function greaterThan($value, $limit)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::greaterThan($value, $limit);
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
function nullOrGreaterThan($value, $limit)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrGreaterThan($value, $limit);
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
function allGreaterThan($value, $limit)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allGreaterThan($value, $limit);
    return $value;
}
