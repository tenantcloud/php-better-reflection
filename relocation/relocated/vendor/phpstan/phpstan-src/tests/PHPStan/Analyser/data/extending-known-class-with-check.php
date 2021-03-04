<?php

namespace TenantCloud\BetterReflection\Relocated\ExtendingKnownClassWithCheck;

if (\class_exists(\TenantCloud\BetterReflection\Relocated\ExtendingKnownClassWithCheck\Bar::class)) {
    class Foo extends \TenantCloud\BetterReflection\Relocated\ExtendingKnownClassWithCheck\Bar
    {
    }
} else {
    class Foo extends \Exception
    {
    }
}
