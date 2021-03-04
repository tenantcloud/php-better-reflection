<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\ClassPropertyNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClassPropertyNode>
 */
class IncompatiblePropertyPhpDocTypeRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck)
    {
        $this->genericObjectTypeCheck = $genericObjectTypeCheck;
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
        $propertyName = $node->getName();
        $propertyReflection = $scope->getClassReflection()->getNativeProperty($propertyName);
        if (!$propertyReflection->hasPhpDoc()) {
            return [];
        }
        $phpDocType = $propertyReflection->getPhpDocType();
        $description = 'PHPDoc tag @var';
        if ($propertyReflection->isPromoted()) {
            $description = 'PHPDoc type';
        }
        $messages = [];
        if ($phpDocType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType || $phpDocType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType && !$phpDocType->isExplicit()) {
            $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s for property %s::$%s contains unresolvable type.', $description, $propertyReflection->getDeclaringClass()->getName(), $propertyName))->build();
        }
        $nativeType = $propertyReflection->getNativeType();
        $isSuperType = $nativeType->isSuperTypeOf($phpDocType);
        if ($isSuperType->no()) {
            $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s for property %s::$%s with type %s is incompatible with native type %s.', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName, $phpDocType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        } elseif ($isSuperType->maybe()) {
            $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s for property %s::$%s with type %s is not subtype of native type %s.', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName, $phpDocType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        $messages = \array_merge($messages, $this->genericObjectTypeCheck->check($phpDocType, \sprintf('%s for property %s::$%s contains generic type %%s but class %%s is not generic.', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName), \sprintf('Generic type %%s in %s for property %s::$%s does not specify all template types of class %%s: %%s', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName), \sprintf('Generic type %%s in %s for property %s::$%s specifies %%d template types, but class %%s supports only %%d: %%s', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName), \sprintf('Type %%s in generic type %%s in %s for property %s::$%s is not subtype of template type %%s of class %%s.', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName)));
        return $messages;
    }
}
