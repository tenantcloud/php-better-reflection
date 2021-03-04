<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

class CountableClass extends \TenantCloud\BetterReflection\Relocated\ClassOk2 implements \Countable
{
    public function count()
    {
    }
}
