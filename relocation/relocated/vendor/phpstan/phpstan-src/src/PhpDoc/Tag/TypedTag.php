<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface TypedTag
{
    public function getType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    /**
     * @param Type $type
     * @return static
     */
    public function withType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : self;
}
