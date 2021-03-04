<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use DateTime;
use stdClass;
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param stdClass|DateTime $value
 */
function notInstanceOf($value) : \DateTime
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::notInstanceOf($value, \stdClass::class);
    return $value;
}
/**
 * @psalm-pure
 * @psalm-template T of object
 *
 * @param mixed $value
 * @param class-string<T> $class
 *
 * @return mixed
 */
function nullOrNotInstanceOf($value, $class)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrNotInstanceOf($value, $class);
    return $value;
}
/**
 * @psalm-pure
 * @psalm-template T of object
 *
 * @param mixed $value
 * @param class-string<T> $class
 *
 * @return mixed
 */
function allNotInstanceOf($value, $class)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allNotInstanceOf($value, $class);
    return $value;
}
