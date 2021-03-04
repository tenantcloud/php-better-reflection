<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\StaticPropertyFetch>
 */
class AccessStaticPropertiesRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\VarLikeIdentifier) {
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
     * @param StaticPropertyFetch $node
     * @param string $name
     * @return RuleError[]
     */
    private function processSingleProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch $node, string $name) : array
    {
        $messages = [];
        if ($node->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            $class = (string) $node->class;
            $lowercasedClass = \strtolower($class);
            if (\in_array($lowercasedClass, ['self', 'static'], \true)) {
                if (!$scope->isInClass()) {
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Accessing %s::$%s outside of class scope.', $class, $name))->build()];
                }
                $classReflection = $scope->getClassReflection();
            } elseif ($lowercasedClass === 'parent') {
                if (!$scope->isInClass()) {
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Accessing %s::$%s outside of class scope.', $class, $name))->build()];
                }
                if ($scope->getClassReflection()->getParentClass() === \false) {
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s::%s() accesses parent::$%s but %s does not extend any class.', $scope->getClassReflection()->getDisplayName(), $scope->getFunctionName(), $name, $scope->getClassReflection()->getDisplayName()))->build()];
                }
                if ($scope->getFunctionName() === null) {
                    throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                }
                $currentMethodReflection = $scope->getClassReflection()->getNativeMethod($scope->getFunctionName());
                if (!$currentMethodReflection->isStatic()) {
                    // calling parent::method() from instance method
                    return [];
                }
                $classReflection = $scope->getClassReflection()->getParentClass();
            } else {
                if (!$this->reflectionProvider->hasClass($class)) {
                    if ($scope->isInClassExists($class)) {
                        return [];
                    }
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to static property $%s on an unknown class %s.', $name, $class))->discoveringSymbolsTip()->build()];
                } else {
                    $messages = $this->classCaseSensitivityCheck->checkClassNames([new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair($class, $node->class)]);
                }
                $classReflection = $this->reflectionProvider->getClass($class);
            }
            $className = $classReflection->getName();
            if ($scope->isInClass() && $scope->getClassReflection()->getName() === $className) {
                $classType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType($scope->getClassReflection());
                $classReflection = $scope->getClassReflection();
            } else {
                $classType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($className);
            }
            if ($classReflection->isTrait()) {
                return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to static property $%s on trait %s.', $name, $className))->build()];
            }
        } else {
            $classTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->class, \sprintf('Access to static property $%s on an unknown class %%s.', $name), static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($name) : bool {
                return $type->canAccessProperties()->yes() && $type->hasProperty($name)->yes();
            });
            $classType = $classTypeResult->getType();
            if ($classType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
                return $classTypeResult->getUnknownClassErrors();
            }
        }
        if ((new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType())->isSuperTypeOf($classType)->yes()) {
            return [];
        }
        $typeForDescribe = $classType;
        if ($classType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType) {
            $typeForDescribe = $classType->getStaticObjectType();
        }
        $classType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove($classType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType());
        if ($scope->isInExpressionAssign($node)) {
            return [];
        }
        if (!$classType->canAccessProperties()->yes()) {
            return \array_merge($messages, [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access static property $%s on %s.', $name, $typeForDescribe->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->build()]);
        }
        if (!$classType->hasProperty($name)->yes()) {
            if ($scope->isSpecified($node)) {
                return $messages;
            }
            return \array_merge($messages, [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to an undefined static property %s::$%s.', $typeForDescribe->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $name))->build()]);
        }
        $property = $classType->getProperty($name, $scope);
        if (!$property->isStatic()) {
            $hasPropertyTypes = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getHasPropertyTypes($classType);
            foreach ($hasPropertyTypes as $hasPropertyType) {
                if ($hasPropertyType->getPropertyName() === $name) {
                    return [];
                }
            }
            return \array_merge($messages, [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Static access to instance property %s::$%s.', $property->getDeclaringClass()->getDisplayName(), $name))->build()]);
        }
        if (!$scope->canAccessProperty($property)) {
            return \array_merge($messages, [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to %s property $%s of class %s.', $property->isPrivate() ? 'private' : 'protected', $name, $property->getDeclaringClass()->getDisplayName()))->build()]);
        }
        return $messages;
    }
}
