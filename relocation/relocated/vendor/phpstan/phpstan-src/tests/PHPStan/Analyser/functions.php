<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
/**
 * Asserts the static type of a value.
 *
 * @param string $type
 * @param mixed $value
 */
function assertType(string $type, $value) : void
{
}
/**
 * Asserts the static type of a value.
 *
 * The difference from assertType() is that it doesn't resolve
 * method/function parameter phpDocs.
 *
 * @param string $type
 * @param mixed $value
 */
function assertNativeType(string $type, $value) : void
{
}
/**
 * @param TrinaryLogic $certainty
 * @param mixed $variable
 */
function assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $certainty, $variable) : void
{
}
