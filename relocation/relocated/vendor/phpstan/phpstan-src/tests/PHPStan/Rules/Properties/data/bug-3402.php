<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3402;

class Foo
{
    /** Some comment */
    /** @var self */
    private $foo;
}
