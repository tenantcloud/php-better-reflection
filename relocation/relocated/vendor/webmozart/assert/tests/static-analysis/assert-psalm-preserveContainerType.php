<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use ArrayIterator;
use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed[] $value
 *
 * @return string[]
 */
function preserveContainerAllArray($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allString($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param ArrayIterator<string, mixed> $value
 *
 * @return ArrayIterator<string, string>
 */
function preserveContainerAllArrayIterator($value)
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allString($value);
    return $value;
}
