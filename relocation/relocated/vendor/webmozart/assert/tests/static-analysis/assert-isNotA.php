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
function isNotA(object $value) : \stdClass
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::isNotA($value, \DateTime::class);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param null|object|string $value
 * @param class-string $class
 *
 * @return null|object|string
 */
function nullOrIsNotA($value, $class)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrIsNotA($value, $class);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param iterable<object|string> $value
 * @param class-string $class
 *
 * @return iterable<object|string>
 */
function allIsNotA($value, $class) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allIsNotA($value, $class);
    return $value;
}
