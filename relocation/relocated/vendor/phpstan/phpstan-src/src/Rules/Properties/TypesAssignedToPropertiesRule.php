<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class TypesAssignedToPropertiesRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyDescriptor $propertyDescriptor;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyDescriptor $propertyDescriptor, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->propertyDescriptor = $propertyDescriptor;
        $this->propertyReflectionFinder = $propertyReflectionFinder;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Assign && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        if (!$node->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch && !$node->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch) {
            return [];
        }
        /** @var \PhpParser\Node\Expr\PropertyFetch|\PhpParser\Node\Expr\StaticPropertyFetch $propertyFetch */
        $propertyFetch = $node->var;
        $propertyReflections = $this->propertyReflectionFinder->findPropertyReflectionsFromNode($propertyFetch, $scope);
        $errors = [];
        foreach ($propertyReflections as $propertyReflection) {
            $errors = \array_merge($errors, $this->processSingleProperty($propertyReflection, $node));
        }
        return $errors;
    }
    /**
     * @param FoundPropertyReflection $propertyReflection
     * @param Node\Expr $node
     * @return RuleError[]
     */
    private function processSingleProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\FoundPropertyReflection $propertyReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $node) : array
    {
        $propertyType = $propertyReflection->getWritableType();
        $scope = $propertyReflection->getScope();
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Assign || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignRef) {
            $assignedValueType = $scope->getType($node->expr);
        } else {
            $assignedValueType = $scope->getType($node);
        }
        if (!$this->ruleLevelHelper->accepts($propertyType, $assignedValueType, $scope->isDeclareStrictTypes())) {
            $propertyDescription = $this->propertyDescriptor->describePropertyByName($propertyReflection, $propertyReflection->getName());
            $verbosityLevel = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($propertyType, $assignedValueType);
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s (%s) does not accept %s.', $propertyDescription, $propertyType->describe($verbosityLevel), $assignedValueType->describe($verbosityLevel)))->build()];
        }
        return [];
    }
}
