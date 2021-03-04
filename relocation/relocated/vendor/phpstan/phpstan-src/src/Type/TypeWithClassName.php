<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

interface TypeWithClassName extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
{
    public function getClassName() : string;
    public function getAncestorWithClassName(string $className) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
}
