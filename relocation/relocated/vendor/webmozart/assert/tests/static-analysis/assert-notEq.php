<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @param mixed $value
 * @param mixed $expect
 *
 * @return mixed
 */
function notEq($value, $expect)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::notEq($value, $expect);
    return $value;
}
/**
 * @param mixed $value
 * @param mixed $expect
 *
 * @return mixed
 */
function nullOrNotEq($value, $expect)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrNotEq($value, $expect);
    return $value;
}
/**
 * @param mixed $value
 * @param mixed $expect
 *
 * @return mixed
 */
function allNotEq($value, $expect)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allNotEq($value, $expect);
    return $value;
}
