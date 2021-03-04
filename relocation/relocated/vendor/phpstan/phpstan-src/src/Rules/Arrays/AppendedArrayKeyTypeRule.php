<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Assign;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Assign>
 */
class AppendedArrayKeyTypeRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder;
    private bool $checkUnionTypes;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder, bool $checkUnionTypes)
    {
        $this->propertyReflectionFinder = $propertyReflectionFinder;
        $this->checkUnionTypes = $checkUnionTypes;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Assign::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        if (!$node->var->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch && !$node->var->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch) {
            return [];
        }
        $propertyReflection = $this->propertyReflectionFinder->findPropertyReflectionFromNode($node->var->var, $scope);
        if ($propertyReflection === null) {
            return [];
        }
        $arrayType = $propertyReflection->getReadableType();
        if (!$arrayType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
            return [];
        }
        if ($node->var->dim !== null) {
            $dimensionType = $scope->getType($node->var->dim);
            $isValidKey = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays\AllowedArrayKeysTypes::getType()->isSuperTypeOf($dimensionType);
            if (!$isValidKey->yes()) {
                // already handled by InvalidKeyInArrayDimFetchRule
                return [];
            }
            $keyType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType::castToArrayKeyType($dimensionType);
            if (!$this->checkUnionTypes && $keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
                return [];
            }
        } else {
            $keyType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
        }
        if (!$arrayType->getIterableKeyType()->isSuperTypeOf($keyType)->yes()) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Array (%s) does not accept key %s.', $arrayType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $keyType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value())))->build()];
        }
        return [];
    }
}
