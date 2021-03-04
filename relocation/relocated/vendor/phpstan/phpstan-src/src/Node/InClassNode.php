<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
class InClassNode extends \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt implements \TenantCloud\BetterReflection\Relocated\PHPStan\Node\VirtualNode
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike $originalNode;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike $originalNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
        $this->classReflection = $classReflection;
    }
    public function getOriginalNode() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike
    {
        return $this->originalNode;
    }
    public function getClassReflection() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->classReflection;
    }
    public function getType() : string
    {
        return 'PHPStan_Stmt_InClassNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
