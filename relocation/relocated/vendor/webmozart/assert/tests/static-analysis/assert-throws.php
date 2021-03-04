<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use Closure;
use Throwable;
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @param class-string<Throwable> $class
 */
function throws(\Closure $value, $class) : \Closure
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::throws($value, $class);
    return $value;
}
/**
 * @param class-string<Throwable> $class
 */
function nullOrThrows(?\Closure $value, $class) : ?\Closure
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrThrows($value, $class);
    return $value;
}
/**
 * @param iterable<Closure> $value
 * @param class-string<Throwable> $class
 *
 * @return iterable<Closure>
 */
function allThrows(iterable $value, $class) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allThrows($value, $class);
    return $value;
}
