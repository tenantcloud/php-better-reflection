<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ClassConstFetch>
 */
class ClassConstantRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->phpVersion = $phpVersion;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
            return [];
        }
        $constantName = $node->name->name;
        $class = $node->class;
        $messages = [];
        if ($class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            $className = (string) $class;
            $lowercasedClassName = \strtolower($className);
            if (\in_array($lowercasedClassName, ['self', 'static'], \true)) {
                if (!$scope->isInClass()) {
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $className))->build()];
                }
                $classReflection = $scope->getClassReflection();
            } elseif ($lowercasedClassName === 'parent') {
                if (!$scope->isInClass()) {
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $className))->build()];
                }
                $currentClassReflection = $scope->getClassReflection();
                if ($currentClassReflection->getParentClass() === \false) {
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to parent::%s but %s does not extend any class.', $constantName, $currentClassReflection->getDisplayName()))->build()];
                }
                $classReflection = $currentClassReflection->getParentClass();
            } else {
                if (!$this->reflectionProvider->hasClass($className)) {
                    if ($scope->isInClassExists($className)) {
                        return [];
                    }
                    if (\strtolower($constantName) === 'class') {
                        return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Class %s not found.', $className))->discoveringSymbolsTip()->build()];
                    }
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to constant %s on an unknown class %s.', $constantName, $className))->discoveringSymbolsTip()->build()];
                } else {
                    $messages = $this->classCaseSensitivityCheck->checkClassNames([new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair($className, $class)]);
                }
                $classReflection = $this->reflectionProvider->getClass($className);
            }
            if (\strtolower($constantName) === 'class') {
                return $messages;
            }
            $className = $classReflection->getName();
            if ($scope->isInClass() && $scope->getClassReflection()->getName() === $className) {
                $classType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType($scope->getClassReflection());
            } else {
                $classType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($className);
            }
        } else {
            $classTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $class, \sprintf('Access to constant %s on an unknown class %%s.', $constantName), static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($constantName) : bool {
                return $type->canAccessConstants()->yes() && $type->hasConstant($constantName)->yes();
            });
            $classType = $classTypeResult->getType();
            if ($classType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
                return $classTypeResult->getUnknownClassErrors();
            }
            if (\strtolower($constantName) === 'class') {
                if (!$this->phpVersion->supportsClassConstantOnExpression()) {
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Accessing ::class constant on an expression is supported only on PHP 8.0 and later.')->nonIgnorable()->build()];
                }
                if ((new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType())->isSuperTypeOf($classType)->yes()) {
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Accessing ::class constant on a dynamic string is not supported in PHP.')->nonIgnorable()->build()];
                }
            }
        }
        if ((new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType())->isSuperTypeOf($classType)->yes()) {
            return $messages;
        }
        $typeForDescribe = $classType;
        if ($classType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType) {
            $typeForDescribe = $classType->getStaticObjectType();
        }
        $classType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove($classType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType());
        if (!$classType->canAccessConstants()->yes()) {
            return \array_merge($messages, [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access constant %s on %s.', $constantName, $typeForDescribe->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->build()]);
        }
        if (\strtolower($constantName) === 'class') {
            return $messages;
        }
        if (!$classType->hasConstant($constantName)->yes()) {
            return \array_merge($messages, [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to undefined constant %s::%s.', $typeForDescribe->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $constantName))->build()]);
        }
        $constantReflection = $classType->getConstant($constantName);
        if (!$scope->canAccessConstant($constantReflection)) {
            return \array_merge($messages, [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to %s constant %s of class %s.', $constantReflection->isPrivate() ? 'private' : 'protected', $constantName, $constantReflection->getDeclaringClass()->getDisplayName()))->build()]);
        }
        return $messages;
    }
}
