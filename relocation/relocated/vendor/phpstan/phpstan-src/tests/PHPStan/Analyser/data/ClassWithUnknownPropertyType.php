<?php

namespace TenantCloud\BetterReflection\Relocated;

class ClassWithUnknownPropertyType
{
    /** @var ClassWithUnknownParent|self */
    protected $test;
}
