<?php

namespace TenantCloud\BetterReflection\Relocated;

/** @var string|null $foo */
$foo = null;
/** @var int|null $bar */
$bar = null;
if ((new \TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClass())->assertString($foo) && \TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClass::assertInt($bar)) {
    die;
}
