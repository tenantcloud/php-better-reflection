<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node;
}
