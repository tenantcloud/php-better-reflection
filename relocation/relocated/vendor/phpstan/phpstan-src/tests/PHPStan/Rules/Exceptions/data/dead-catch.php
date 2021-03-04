<?php

namespace TenantCloud\BetterReflection\Relocated\DeadCatch;

class Foo
{
    public function doFoo()
    {
        try {
        } catch (\Exception $e) {
        } catch (\TypeError $e) {
        } catch (\Throwable $t) {
        }
    }
    public function doBar()
    {
        try {
        } catch (\Throwable $e) {
        } catch (\TypeError $e) {
        }
    }
}
