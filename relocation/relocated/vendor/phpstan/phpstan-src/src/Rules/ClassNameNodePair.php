<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
class ClassNameNodePair
{
    private string $className;
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node $node;
    public function __construct(string $className, \TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
    {
        $this->className = $className;
        $this->node = $node;
    }
    public function getClassName() : string
    {
        return $this->className;
    }
    public function getNode() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node
    {
        return $this->node;
    }
}
