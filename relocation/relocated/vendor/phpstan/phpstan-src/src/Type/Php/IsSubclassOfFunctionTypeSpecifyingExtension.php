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
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FunctionTypeSpecifyingExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
class IsSubclassOfFunctionTypeSpecifyingExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FunctionTypeSpecifyingExtension, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier;
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_subclass_of' && \count($node->args) >= 2 && !$context->null();
    }
    public function specifyTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes
    {
        $objectType = $scope->getType($node->args[0]->value);
        $classType = $scope->getType($node->args[1]->value);
        $allowStringType = isset($node->args[2]) ? $scope->getType($node->args[2]->value) : new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true);
        $allowString = !$allowStringType->equals(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false));
        if (!$classType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
            if ($context->truthy()) {
                if ($allowString) {
                    $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType());
                } else {
                    $type = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType();
                }
                return $this->typeSpecifier->create($node->args[0]->value, $type, $context);
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes();
        }
        $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($objectType, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) use($classType, $allowString) : Type {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
                return $traverse($type);
            }
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
                return $traverse($type);
            }
            if ($allowString) {
                if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType) {
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($classType->getValue()));
                }
            }
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($classType->getValue());
            }
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
                $objectType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($classType->getValue());
                if ($allowString) {
                    return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType($objectType), $objectType);
                }
                return $objectType;
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
        });
        return $this->typeSpecifier->create($node->args[0]->value, $type, $context);
    }
    public function setTypeSpecifier(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
