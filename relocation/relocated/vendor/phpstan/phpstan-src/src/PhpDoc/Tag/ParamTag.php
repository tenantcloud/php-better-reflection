<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class ParamTag implements \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\TypedTag
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type;
    private bool $isVariadic;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $isVariadic)
    {
        $this->type = $type;
        $this->isVariadic = $isVariadic;
    }
    public function getType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function isVariadic() : bool
    {
        return $this->isVariadic;
    }
    /**
     * @param Type $type
     * @return self
     */
    public function withType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\TypedTag
    {
        return new self($type, $this->isVariadic);
    }
}
