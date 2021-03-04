<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\PropertyFetch>
 */
class AccessPropertiesRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper;
    private bool $reportMagicProperties;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, bool $reportMagicProperties)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->reportMagicProperties = $reportMagicProperties;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
            $names = [$node->name->name];
        } else {
            $names = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType $type) : string {
                return $type->getValue();
            }, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($node->name)));
        }
        $errors = [];
        foreach ($names as $name) {
            $errors = \array_merge($errors, $this->processSingleProperty($scope, $node, $name));
        }
        return $errors;
    }
    /**
     * @param Scope $scope
     * @param PropertyFetch $node
     * @param string $name
     * @return RuleError[]
     */
    private function processSingleProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch $node, string $name) : array
    {
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->var, \sprintf('Access to property $%s on an unknown class %%s.', $name), static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($name) : bool {
            return $type->canAccessProperties()->yes() && $type->hasProperty($name)->yes();
        });
        $type = $typeResult->getType();
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        if ($scope->isInExpressionAssign($node)) {
            return [];
        }
        if (!$type->canAccessProperties()->yes()) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access property $%s on %s.', $name, $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        }
        if (!$type->hasProperty($name)->yes()) {
            if ($scope->isSpecified($node)) {
                return [];
            }
            $classNames = $typeResult->getReferencedClasses();
            if (!$this->reportMagicProperties) {
                foreach ($classNames as $className) {
                    if (!$this->reflectionProvider->hasClass($className)) {
                        continue;
                    }
                    $classReflection = $this->reflectionProvider->getClass($className);
                    if ($classReflection->hasNativeMethod('__get') || $classReflection->hasNativeMethod('__set')) {
                        return [];
                    }
                }
            }
            if (\count($classNames) === 1) {
                $referencedClass = $typeResult->getReferencedClasses()[0];
                $propertyClassReflection = $this->reflectionProvider->getClass($referencedClass);
                $parentClassReflection = $propertyClassReflection->getParentClass();
                while ($parentClassReflection !== \false) {
                    if ($parentClassReflection->hasProperty($name)) {
                        return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to private property $%s of parent class %s.', $name, $parentClassReflection->getDisplayName()))->build()];
                    }
                    $parentClassReflection = $parentClassReflection->getParentClass();
                }
            }
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to an undefined property %s::$%s.', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $name))->build()];
        }
        $propertyReflection = $type->getProperty($name, $scope);
        if (!$scope->canAccessProperty($propertyReflection)) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to %s property %s::$%s.', $propertyReflection->isPrivate() ? 'private' : 'protected', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $name))->build()];
        }
        return [];
    }
}
