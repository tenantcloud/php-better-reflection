<?php

namespace TenantCloud\BetterReflection\Relocated\UnionIterableTypeIssue;

/**
 * @param int|mixed[]|null $var
 */
function foo($var)
{
}
/**
 * @param int|null $var
 */
function bar($var)
{
    foo($var);
}
