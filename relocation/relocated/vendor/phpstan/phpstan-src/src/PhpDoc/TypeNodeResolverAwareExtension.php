<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc;

interface TypeNodeResolverAwareExtension
{
    public function setTypeNodeResolver(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver) : void;
}
