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
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasMethodType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FunctionTypeSpecifyingExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
class MethodExistsTypeSpecifyingExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FunctionTypeSpecifyingExtension, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier;
    public function setTypeSpecifier(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $functionReflection->getName() === 'method_exists' && $context->truthy() && \count($node->args) >= 2;
    }
    public function specifyTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes
    {
        $objectType = $scope->getType($node->args[0]->value);
        if (!$objectType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType) {
            if ((new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType())->isSuperTypeOf($objectType)->yes()) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes([], []);
            }
        }
        $methodNameType = $scope->getType($node->args[1]->value);
        if (!$methodNameType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasMethodType($methodNameType->getValue())]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType()]), $context);
    }
}
