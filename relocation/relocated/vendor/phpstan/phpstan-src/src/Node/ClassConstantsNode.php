<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassConst;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\Constant\ClassConstantFetch;
class ClassConstantsNode extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract implements \TenantCloud\BetterReflection\Relocated\PHPStan\Node\VirtualNode
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike $class;
    /** @var ClassConst[] */
    private array $constants;
    /** @var ClassConstantFetch[] */
    private array $fetches;
    /**
     * @param ClassLike $class
     * @param ClassConst[] $constants
     * @param ClassConstantFetch[] $fetches
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike $class, array $constants, array $fetches)
    {
        parent::__construct($class->getAttributes());
        $this->class = $class;
        $this->constants = $constants;
        $this->fetches = $fetches;
    }
    public function getClass() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike
    {
        return $this->class;
    }
    /**
     * @return ClassConst[]
     */
    public function getConstants() : array
    {
        return $this->constants;
    }
    /**
     * @return ClassConstantFetch[]
     */
    public function getFetches() : array
    {
        return $this->fetches;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_ClassPropertiesNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
