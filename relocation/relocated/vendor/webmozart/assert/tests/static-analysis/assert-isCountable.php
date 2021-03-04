<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use Countable;
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return countable
 */
function isCountable($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isCountable($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return null|countable
 */
function nullOrIsCountable($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsCountable($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<countable>
 */
function allIsCountable($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsCountable($value);
    return $value;
}
