<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

require_once __DIR__ . '/bootstrap.php';
\TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase::$useStaticReflectionProvider = \true;
\TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase::getContainer();
