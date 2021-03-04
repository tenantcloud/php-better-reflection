<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class VarTag implements \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\TypedTag
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type)
    {
        $this->type = $type;
    }
    public function getType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->type;
    }
    /**
     * @param Type $type
     * @return self
     */
    public function withType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\TypedTag
    {
        return new self($type);
    }
}
