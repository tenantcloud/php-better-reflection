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
function alpha($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::alpha($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function nullOrAlpha($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrAlpha($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function allAlpha($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allAlpha($value);
    return $value;
}
