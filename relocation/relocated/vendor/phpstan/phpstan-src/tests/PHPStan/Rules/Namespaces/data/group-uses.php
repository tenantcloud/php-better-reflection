<?php

namespace TenantCloud\BetterReflection\Relocated\SomeOtherUseNamespace;

use function TenantCloud\BetterReflection\Relocated\Uses\Foo;
use function TenantCloud\BetterReflection\Relocated\Uses\baz;
use TenantCloud\BetterReflection\Relocated\Uses\Bar;
use TenantCloud\BetterReflection\Relocated\Uses\LOREM;
use TenantCloud\BetterReflection\Relocated\Uses\Nonexistent;
use function TenantCloud\BetterReflection\Relocated\Uses\Foo as fooFunctionAgain;
use const TenantCloud\BetterReflection\Relocated\Uses\MY_CONSTANT;
use const TenantCloud\BetterReflection\Relocated\Uses\OTHER_CONSTANT;
use const TenantCloud\BetterReflection\Relocated\Uses\MY_CONSTANT as MY_CONSTANT_AGAIN;
