<?php

namespace TenantCloud\BetterReflection\Relocated\NegatedInstanceOf;

class Foo
{
    public function someMethod($foo, $bar, $otherBar, $lorem, $otherLorem, $dolor, $sit, $mixedFoo, $mixedBar, $self, $static, $anotherFoo, $fooAndBar)
    {
        if (!$foo instanceof \TenantCloud\BetterReflection\Relocated\NegatedInstanceOf\Foo) {
            return;
        }
        if (!$bar instanceof \TenantCloud\BetterReflection\Relocated\NegatedInstanceOf\Bar || \get_class($bar) !== \get_class($otherBar)) {
            return;
        }
        if (!($lorem instanceof \TenantCloud\BetterReflection\Relocated\NegatedInstanceOf\Lorem || \get_class($lorem) === \get_class($otherLorem))) {
            // still mixed after if
            return;
        }
        if ($dolor instanceof \TenantCloud\BetterReflection\Relocated\NegatedInstanceOf\Dolor) {
            // still mixed after if
            return;
        }
        if (!!$sit instanceof \TenantCloud\BetterReflection\Relocated\NegatedInstanceOf\Sit) {
            // still mixed after if
            return;
        }
        if ($mixedFoo instanceof \TenantCloud\BetterReflection\Relocated\NegatedInstanceOf\Foo && doFoo()) {
            return;
        }
        if (!$mixedBar instanceof \TenantCloud\BetterReflection\Relocated\NegatedInstanceOf\Bar && doFoo()) {
            return;
        }
        if (!$self instanceof self) {
            return;
        }
        if (!$static instanceof static) {
            return;
        }
        if ($anotherFoo instanceof \TenantCloud\BetterReflection\Relocated\NegatedInstanceOf\Foo === \false) {
            return;
        }
        if ($fooAndBar instanceof \TenantCloud\BetterReflection\Relocated\NegatedInstanceOf\Foo && $fooAndBar instanceof \TenantCloud\BetterReflection\Relocated\NegatedInstanceOf\Bar) {
            die;
        }
    }
}
