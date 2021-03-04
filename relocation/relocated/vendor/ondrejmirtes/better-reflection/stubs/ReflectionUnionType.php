<?php

namespace TenantCloud\BetterReflection\Relocated;

if (\class_exists('ReflectionUnionType', \false)) {
    return;
}
class ReflectionUnionType extends \ReflectionType
{
    /** @return ReflectionType[] */
    public function getTypes()
    {
        return [];
    }
}
