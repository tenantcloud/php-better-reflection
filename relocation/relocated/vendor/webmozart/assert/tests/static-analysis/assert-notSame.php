<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param mixed $expect
 *
 * @return mixed
 */
function notSame($value, $expect)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::notSame($value, $expect);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param mixed $expect
 *
 * @return mixed
 */
function nullOrNotSame($value, $expect)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrNotSame($value, $expect);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param mixed $expect
 *
 * @return mixed
 */
function allNotSame($value, $expect)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allNotSame($value, $expect);
    return $value;
}
