<?php

namespace TenantCloud\BetterReflection\Relocated\ConstantConditionNotPhpDoc;

class BooleanNot
{
    /**
     * @param object $object
     */
    public function doFoo(self $self, $object)
    {
        if (!$self) {
        }
        if (!$object) {
        }
    }
}
