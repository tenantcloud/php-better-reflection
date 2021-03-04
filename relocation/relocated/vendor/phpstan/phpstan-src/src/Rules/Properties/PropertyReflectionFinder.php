<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\VarLikeIdentifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
class PropertyReflectionFinder
{
    /**
     * @param \PhpParser\Node\Expr\PropertyFetch|\PhpParser\Node\Expr\StaticPropertyFetch $propertyFetch
     * @param \PHPStan\Analyser\Scope $scope
     * @return FoundPropertyReflection[]
     */
    public function findPropertyReflectionsFromNode($propertyFetch, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if ($propertyFetch instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch) {
            if ($propertyFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
                $names = [$propertyFetch->name->name];
            } else {
                $names = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType $name) : string {
                    return $name->getValue();
                }, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($propertyFetch->name)));
            }
            $reflections = [];
            $propertyHolderType = $scope->getType($propertyFetch->var);
            $fetchedOnThis = $propertyHolderType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType && $scope->isInClass();
            foreach ($names as $name) {
                $reflection = $this->findPropertyReflection($propertyHolderType, $name, $propertyFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr ? $scope->filterByTruthyValue(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical($propertyFetch->name, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_($name))) : $scope, $fetchedOnThis);
                if ($reflection === null) {
                    continue;
                }
                $reflections[] = $reflection;
            }
            return $reflections;
        }
        if ($propertyFetch->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            $propertyHolderType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($scope->resolveName($propertyFetch->class));
        } else {
            $propertyHolderType = $scope->getType($propertyFetch->class);
        }
        $fetchedOnThis = $propertyHolderType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType && $scope->isInClass();
        if ($propertyFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\VarLikeIdentifier) {
            $names = [$propertyFetch->name->name];
        } else {
            $names = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType $name) : string {
                return $name->getValue();
            }, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($propertyFetch->name)));
        }
        $reflections = [];
        foreach ($names as $name) {
            $reflection = $this->findPropertyReflection($propertyHolderType, $name, $propertyFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr ? $scope->filterByTruthyValue(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical($propertyFetch->name, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_($name))) : $scope, $fetchedOnThis);
            if ($reflection === null) {
                continue;
            }
            $reflections[] = $reflection;
        }
        return $reflections;
    }
    /**
     * @param \PhpParser\Node\Expr\PropertyFetch|\PhpParser\Node\Expr\StaticPropertyFetch $propertyFetch
     * @param \PHPStan\Analyser\Scope $scope
     * @return FoundPropertyReflection|null
     */
    public function findPropertyReflectionFromNode($propertyFetch, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\FoundPropertyReflection
    {
        if ($propertyFetch instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch) {
            if (!$propertyFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
                return null;
            }
            $propertyHolderType = $scope->getType($propertyFetch->var);
            $fetchedOnThis = $propertyHolderType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType && $scope->isInClass();
            return $this->findPropertyReflection($propertyHolderType, $propertyFetch->name->name, $scope, $fetchedOnThis);
        }
        if (!$propertyFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
            return null;
        }
        if ($propertyFetch->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            $propertyHolderType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($scope->resolveName($propertyFetch->class));
        } else {
            $propertyHolderType = $scope->getType($propertyFetch->class);
        }
        $fetchedOnThis = $propertyHolderType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType && $scope->isInClass();
        return $this->findPropertyReflection($propertyHolderType, $propertyFetch->name->name, $scope, $fetchedOnThis);
    }
    private function findPropertyReflection(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $propertyHolderType, string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, bool $fetchedOnThis) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\FoundPropertyReflection
    {
        $transformedPropertyHolderType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($propertyHolderType, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) use($scope, $fetchedOnThis) : Type {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType) {
                if ($fetchedOnThis && $scope->isInClass()) {
                    return $traverse($type->changeBaseClass($scope->getClassReflection()));
                }
                if ($scope->isInClass()) {
                    return $traverse($type->changeBaseClass($scope->getClassReflection())->getStaticObjectType());
                }
            }
            return $traverse($type);
        });
        if (!$transformedPropertyHolderType->hasProperty($propertyName)->yes()) {
            return null;
        }
        $originalProperty = $transformedPropertyHolderType->getProperty($propertyName, $scope);
        $readableType = $this->transformPropertyType($originalProperty->getReadableType(), $transformedPropertyHolderType, $scope, $fetchedOnThis);
        $writableType = $this->transformPropertyType($originalProperty->getWritableType(), $transformedPropertyHolderType, $scope, $fetchedOnThis);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\FoundPropertyReflection($originalProperty, $scope, $propertyName, $readableType, $writableType);
    }
    private function transformPropertyType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $propertyType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $transformedPropertyHolderType, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, bool $fetchedOnThis) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($propertyType, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $propertyType, callable $traverse) use($transformedPropertyHolderType, $scope, $fetchedOnThis) : Type {
            if ($propertyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType) {
                if ($fetchedOnThis && $scope->isInClass()) {
                    return $traverse($propertyType->changeBaseClass($scope->getClassReflection()));
                }
                return $traverse($transformedPropertyHolderType);
            }
            return $traverse($propertyType);
        });
    }
}
