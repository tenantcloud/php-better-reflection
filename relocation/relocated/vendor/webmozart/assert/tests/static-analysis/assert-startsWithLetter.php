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
function startsWithLetter($value, string $prefix)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::startsWithLetter($value, $prefix);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function nullOrStartsWithLetter($value, string $prefix)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrStartsWithLetter($value, $prefix);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function allStartsWithLetter($value, string $prefix)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allStartsWithLetter($value, $prefix);
    return $value;
}
