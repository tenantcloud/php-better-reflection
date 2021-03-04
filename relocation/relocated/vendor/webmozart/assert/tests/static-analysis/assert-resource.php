<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param null|string $type
 *
 * @return resource
 */
function resource($value, $type)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::resource($value, $type);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param null|string $type
 *
 * @return null|resource
 */
function nullOrResource($value, $type)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrResource($value, $type);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 * @param null|string $type
 *
 * @return iterable<resource>
 */
function allResource($value, $type) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allResource($value, $type);
    return $value;
}
