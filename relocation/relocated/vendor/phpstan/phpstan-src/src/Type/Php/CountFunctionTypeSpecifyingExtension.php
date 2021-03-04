<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierAwareExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FunctionTypeSpecifyingExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
class CountFunctionTypeSpecifyingExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FunctionTypeSpecifyingExtension, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier;
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return !$context->null() && \count($node->args) >= 1 && $functionReflection->getName() === 'count';
    }
    public function specifyTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes
    {
        if (!(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()))->isSuperTypeOf($scope->getType($node->args[0]->value))->yes()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType(), $context);
    }
    public function setTypeSpecifier(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
