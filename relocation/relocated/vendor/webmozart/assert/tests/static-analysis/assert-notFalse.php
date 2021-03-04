<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @return true
 */
function notFalseBool(bool $value) : bool
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::notFalse($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param false|string $value
 */
function notFalseUnion($value) : string
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::notFalse($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function nullOrNotFalse($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrNotFalse($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function allNotFalse($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allNotFalse($value);
    return $value;
}
