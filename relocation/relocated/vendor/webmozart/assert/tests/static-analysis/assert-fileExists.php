<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @param mixed $value
 *
 * @return mixed
 */
function fileExists($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::fileExists($value);
    return $value;
}
/**
 * @param mixed $value
 *
 * @return mixed
 */
function nullOrFileExists($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrFileExists($value);
    return $value;
}
/**
 * @param mixed $value
 *
 * @return mixed
 */
function allFileExists($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allFileExists($value);
    return $value;
}
