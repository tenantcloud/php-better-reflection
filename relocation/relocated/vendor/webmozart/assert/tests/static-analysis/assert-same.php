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
function same($value, $expect)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::same($value, $expect);
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
function nullOrSame($value, $expect)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrSame($value, $expect);
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
function allSame($value, $expect)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allSame($value, $expect);
    return $value;
}
