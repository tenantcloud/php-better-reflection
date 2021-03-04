<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeMethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionCallParametersCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\StaticCall>
 */
class CallStaticMethodsRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionCallParametersCheck $check;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck;
    private bool $checkFunctionNameCase;
    private bool $reportMagicMethods;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionCallParametersCheck $check, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, bool $checkFunctionNameCase, bool $reportMagicMethods)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->check = $check;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->checkFunctionNameCase = $checkFunctionNameCase;
        $this->reportMagicMethods = $reportMagicMethods;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
            return [];
        }
        $methodName = $node->name->name;
        $class = $node->class;
        $errors = [];
        $isAbstract = \false;
        if ($class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            $className = (string) $class;
            $lowercasedClassName = \strtolower($className);
            if (\in_array($lowercasedClassName, ['self', 'static'], \true)) {
                if (!$scope->isInClass()) {
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Calling %s::%s() outside of class scope.', $className, $methodName))->build()];
                }
                $classReflection = $scope->getClassReflection();
            } elseif ($lowercasedClassName === 'parent') {
                if (!$scope->isInClass()) {
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Calling %s::%s() outside of class scope.', $className, $methodName))->build()];
                }
                $currentClassReflection = $scope->getClassReflection();
                if ($currentClassReflection->getParentClass() === \false) {
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s::%s() calls parent::%s() but %s does not extend any class.', $scope->getClassReflection()->getDisplayName(), $scope->getFunctionName(), $methodName, $scope->getClassReflection()->getDisplayName()))->build()];
                }
                if ($scope->getFunctionName() === null) {
                    throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                }
                $classReflection = $currentClassReflection->getParentClass();
            } else {
                if (!$this->reflectionProvider->hasClass($className)) {
                    if ($scope->isInClassExists($className)) {
                        return [];
                    }
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to static method %s() on an unknown class %s.', $methodName, $className))->discoveringSymbolsTip()->build()];
                } else {
                    $errors = $this->classCaseSensitivityCheck->checkClassNames([new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair($className, $class)]);
                }
                $classReflection = $this->reflectionProvider->getClass($className);
            }
            $className = $classReflection->getName();
            if ($scope->isInClass() && $scope->getClassReflection()->getName() === $className) {
                $classType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType($scope->getClassReflection());
                $classReflection = $scope->getClassReflection();
            } else {
                $classType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($className);
            }
            if ($classReflection->hasNativeMethod($methodName) && $lowercasedClassName !== 'static') {
                $nativeMethodReflection = $classReflection->getNativeMethod($methodName);
                if ($nativeMethodReflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodReflection || $nativeMethodReflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeMethodReflection) {
                    $isAbstract = $nativeMethodReflection->isAbstract();
                }
            }
        } else {
            $classTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $class, \sprintf('Call to static method %s() on an unknown class %%s.', $methodName), static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($methodName) : bool {
                return $type->canCallMethods()->yes() && $type->hasMethod($methodName)->yes();
            });
            $classType = $classTypeResult->getType();
            if ($classType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
                return $classTypeResult->getUnknownClassErrors();
            }
        }
        if ($classType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType) {
            $classType = $classType->getGenericType();
            if (!(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType())->isSuperTypeOf($classType)->yes()) {
                return [];
            }
        } elseif ((new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType())->isSuperTypeOf($classType)->yes()) {
            return [];
        }
        $typeForDescribe = $classType;
        if ($classType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType) {
            $typeForDescribe = $classType->getStaticObjectType();
        }
        $classType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove($classType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType());
        if (!$classType->canCallMethods()->yes()) {
            return \array_merge($errors, [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot call static method %s() on %s.', $methodName, $typeForDescribe->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->build()]);
        }
        if (!$classType->hasMethod($methodName)->yes()) {
            if (!$this->reportMagicMethods) {
                $directClassNames = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getDirectClassNames($classType);
                foreach ($directClassNames as $className) {
                    if (!$this->reflectionProvider->hasClass($className)) {
                        continue;
                    }
                    $classReflection = $this->reflectionProvider->getClass($className);
                    if ($classReflection->hasNativeMethod('__callStatic')) {
                        return [];
                    }
                }
            }
            return \array_merge($errors, [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to an undefined static method %s::%s().', $typeForDescribe->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $methodName))->build()]);
        }
        $method = $classType->getMethod($methodName, $scope);
        if (!$method->isStatic()) {
            $function = $scope->getFunction();
            if (!$function instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection || $function->isStatic() || !$scope->isInClass() || $classType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName && $scope->getClassReflection()->getName() !== $classType->getClassName() && !$scope->getClassReflection()->isSubclassOf($classType->getClassName())) {
                return \array_merge($errors, [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Static call to instance method %s::%s().', $method->getDeclaringClass()->getDisplayName(), $method->getName()))->build()]);
            }
        }
        if (!$scope->canCallMethod($method)) {
            $errors = \array_merge($errors, [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s %s %s() of class %s.', $method->isPrivate() ? 'private' : 'protected', $method->isStatic() ? 'static method' : 'method', $method->getName(), $method->getDeclaringClass()->getDisplayName()))->build()]);
        }
        if ($isAbstract) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot call abstract%s method %s::%s().', $method->isStatic() ? ' static' : '', $method->getDeclaringClass()->getDisplayName(), $method->getName()))->build()];
        }
        $lowercasedMethodName = \sprintf('%s %s', $method->isStatic() ? 'static method' : 'method', $method->getDeclaringClass()->getDisplayName() . '::' . $method->getName() . '()');
        $displayMethodName = \sprintf('%s %s', $method->isStatic() ? 'Static method' : 'Method', $method->getDeclaringClass()->getDisplayName() . '::' . $method->getName() . '()');
        $errors = \array_merge($errors, $this->check->check(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $node->args, $method->getVariants()), $scope, $method->getDeclaringClass()->isBuiltin(), $node, [$displayMethodName . ' invoked with %d parameter, %d required.', $displayMethodName . ' invoked with %d parameters, %d required.', $displayMethodName . ' invoked with %d parameter, at least %d required.', $displayMethodName . ' invoked with %d parameters, at least %d required.', $displayMethodName . ' invoked with %d parameter, %d-%d required.', $displayMethodName . ' invoked with %d parameters, %d-%d required.', 'Parameter %s of ' . $lowercasedMethodName . ' expects %s, %s given.', 'Result of ' . $lowercasedMethodName . ' (void) is used.', 'Parameter %s of ' . $lowercasedMethodName . ' is passed by reference, so it expects variables only.', 'Unable to resolve the template type %s in call to method ' . $lowercasedMethodName, 'Missing parameter $%s in call to ' . $lowercasedMethodName . '.', 'Unknown parameter $%s in call to ' . $lowercasedMethodName . '.']));
        if ($this->checkFunctionNameCase && $method->getName() !== $methodName) {
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s with incorrect case: %s', $lowercasedMethodName, $methodName))->build();
        }
        return $errors;
    }
}
