<?php

namespace TenantCloud\BetterReflection\Relocated\TraitsWrongProperty;

use TenantCloud\BetterReflection\Relocated\Ipsum as Bar;
trait FooTrait
{
    /** @var int */
    private $id;
    /** @var Bar */
    private $bar;
}
