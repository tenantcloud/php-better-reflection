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
function lessThan($value, $limit)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::lessThan($value, $limit);
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
function nullOrLessThan($value, $limit)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrLessThan($value, $limit);
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
function allLessThan($value, $limit)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allLessThan($value, $limit);
    return $value;
}
