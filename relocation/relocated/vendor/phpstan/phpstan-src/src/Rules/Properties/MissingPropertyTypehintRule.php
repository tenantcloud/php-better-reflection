<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\ClassPropertyNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClassPropertyNode>
 */
final class MissingPropertyTypehintRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck)
    {
        $this->missingTypehintCheck = $missingTypehintCheck;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Node\ClassPropertyNode::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $propertyReflection = $scope->getClassReflection()->getNativeProperty($node->getName());
        $propertyType = $propertyReflection->getReadableType();
        if ($propertyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$propertyType->isExplicitMixed()) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Property %s::$%s has no typehint specified.', $propertyReflection->getDeclaringClass()->getDisplayName(), $node->getName()))->build()];
        }
        $messages = [];
        foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($propertyType) as $iterableType) {
            $iterableTypeDescription = $iterableType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly());
            $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Property %s::$%s type has no value type specified in iterable type %s.', $propertyReflection->getDeclaringClass()->getDisplayName(), $node->getName(), $iterableTypeDescription))->tip(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP)->build();
        }
        foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($propertyType) as [$name, $genericTypeNames]) {
            $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Property %s::$%s with generic %s does not specify its types: %s', $propertyReflection->getDeclaringClass()->getDisplayName(), $node->getName(), $name, \implode(', ', $genericTypeNames)))->tip(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
        }
        foreach ($this->missingTypehintCheck->getCallablesWithMissingSignature($propertyType) as $callableType) {
            $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Property %s::$%s type has no signature specified for %s.', $propertyReflection->getDeclaringClass()->getDisplayName(), $node->getName(), $callableType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        return $messages;
    }
}
