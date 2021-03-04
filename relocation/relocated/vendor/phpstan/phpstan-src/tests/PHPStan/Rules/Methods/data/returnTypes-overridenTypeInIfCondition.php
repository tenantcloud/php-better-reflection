<?php

namespace TenantCloud\BetterReflection\Relocated\ReturnTypes;

class OverridenTypeInIfCondition
{
    public function getAnotherAnotherStock() : \TenantCloud\BetterReflection\Relocated\ReturnTypes\Stock
    {
        $stock = new \TenantCloud\BetterReflection\Relocated\ReturnTypes\Stock();
        if ($stock->findStock() === null) {
        }
        return $stock->findStock();
    }
}
