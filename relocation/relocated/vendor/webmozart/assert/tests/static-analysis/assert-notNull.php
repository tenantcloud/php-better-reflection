<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 */
function notNull(?object $value) : object
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::notNull($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function allNotNull($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allNotNull($value);
    return $value;
}
