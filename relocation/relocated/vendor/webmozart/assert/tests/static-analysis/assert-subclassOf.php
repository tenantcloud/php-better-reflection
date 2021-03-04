<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use stdClass;
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return class-string<stdClass>|stdClass
 */
function subclassOf($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::subclassOf($value, \stdClass::class);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return null|class-string<stdClass>|stdClass
 */
function nullOrSubclassOf($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrSubclassOf($value, \stdClass::class);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<class-string<stdClass>|stdClass>
 */
function allSubclassOf($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allSubclassOf($value, \stdClass::class);
    return $value;
}
