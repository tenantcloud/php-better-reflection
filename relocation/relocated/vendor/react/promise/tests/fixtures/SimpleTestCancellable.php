<?php

namespace TenantCloud\BetterReflection\Relocated\React\Promise;

class SimpleTestCancellable
{
    public $cancelCalled = \false;
    public function cancel()
    {
        $this->cancelCalled = \true;
    }
}
