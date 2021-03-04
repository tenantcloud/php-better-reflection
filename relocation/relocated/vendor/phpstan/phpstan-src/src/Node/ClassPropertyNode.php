<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\NullableType;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\UnionType;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract;
class ClassPropertyNode extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract implements \TenantCloud\BetterReflection\Relocated\PHPStan\Node\VirtualNode
{
    private string $name;
    private int $flags;
    /** @var Identifier|Name|NullableType|UnionType|null */
    private $type;
    private ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $default;
    private ?string $phpDoc;
    private bool $isPromoted;
    /**
     * @param int $flags
     * @param Identifier|Name|NullableType|UnionType|null $type
     * @param string $name
     * @param Expr|null $default
     */
    public function __construct(string $name, int $flags, $type, ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $default, ?string $phpDoc, bool $isPromoted, \TenantCloud\BetterReflection\Relocated\PhpParser\Node $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->name = $name;
        $this->flags = $flags;
        $this->type = $type;
        $this->default = $default;
        $this->isPromoted = $isPromoted;
        $this->phpDoc = $phpDoc;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getFlags() : int
    {
        return $this->flags;
    }
    public function getDefault() : ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr
    {
        return $this->default;
    }
    public function isPromoted() : bool
    {
        return $this->isPromoted;
    }
    public function getPhpDoc() : ?string
    {
        return $this->phpDoc;
    }
    public function isPublic() : bool
    {
        return ($this->flags & \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC) !== 0 || ($this->flags & \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::VISIBILITY_MODIFIER_MASK) === 0;
    }
    public function isProtected() : bool
    {
        return (bool) ($this->flags & \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::MODIFIER_PROTECTED);
    }
    public function isPrivate() : bool
    {
        return (bool) ($this->flags & \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE);
    }
    public function isStatic() : bool
    {
        return (bool) ($this->flags & \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::MODIFIER_STATIC);
    }
    /**
     * @return Identifier|Name|NullableType|UnionType|null
     */
    public function getNativeType()
    {
        return $this->type;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_ClassPropertyNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
