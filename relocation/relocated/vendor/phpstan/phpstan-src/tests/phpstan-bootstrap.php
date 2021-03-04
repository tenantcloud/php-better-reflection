<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

require_once __DIR__ . '/PHPStan/Analyser/functions.php';
\class_alias(\TenantCloud\BetterReflection\Relocated\ReturnTypes\Foo::class, \TenantCloud\BetterReflection\Relocated\ReturnTypes\FooAlias::class, \true);
\class_alias(\TenantCloud\BetterReflection\Relocated\TestAccessProperties\FooAccessProperties::class, \TenantCloud\BetterReflection\Relocated\TestAccessProperties\FooAccessPropertiesAlias::class, \true);
