<?php

namespace TenantCloud\BetterReflection\Relocated\SomeOtherUseNamespace;

use TenantCloud\BetterReflection\Relocated\Uses\Bar;
use TenantCloud\BetterReflection\Relocated\Uses\Nonexistent;
// could be namespace
use function TenantCloud\BetterReflection\Relocated\Uses\foo as fooFunction, TenantCloud\BetterReflection\Relocated\Uses\bar;
use const TenantCloud\BetterReflection\Relocated\Uses\MY_CONSTANT, TenantCloud\BetterReflection\Relocated\Uses\OTHER_CONSTANT;
use function TenantCloud\BetterReflection\Relocated\Uses\Foo;
use TenantCloud\BetterReflection\Relocated\Uses\LOREM;
use TenantCloud\BetterReflection\Relocated\DATETIME;
