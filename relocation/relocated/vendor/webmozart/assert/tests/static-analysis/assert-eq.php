<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @param mixed $value
 * @param mixed $expect
 *
 * @return mixed
 */
function eq($value, $expect)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::eq($value, $expect);
    return $value;
}
/**
 * @param mixed $value
 * @param mixed $expect
 *
 * @return mixed
 */
function nullOrEq($value, $expect)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrEq($value, $expect);
    return $value;
}
/**
 * @param mixed $value
 * @param mixed $expect
 *
 * @return mixed
 */
function allEq($value, $expect)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allEq($value, $expect);
    return $value;
}
