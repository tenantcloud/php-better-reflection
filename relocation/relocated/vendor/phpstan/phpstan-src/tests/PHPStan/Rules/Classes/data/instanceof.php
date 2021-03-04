<?php

namespace TenantCloud\BetterReflection\Relocated\InstanceOfNamespace;

if ($foo instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\Foo) {
} elseif ($foo instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\Bar) {
} elseif ($foo instanceof self) {
} elseif ($foo instanceof $bar) {
} elseif ($foo instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\FOO) {
} elseif ($foo instanceof parent) {
} elseif ($foo instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\SELF) {
}
