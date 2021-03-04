<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface TypeNodeResolverExtension
{
    public const EXTENSION_TAG = 'phpstan.phpDoc.typeNodeResolverExtension';
    public function resolve(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
}
