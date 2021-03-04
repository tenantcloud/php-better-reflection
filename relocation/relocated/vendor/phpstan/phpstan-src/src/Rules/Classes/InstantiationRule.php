<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\New_;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionCallParametersCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\New_>
 */
class InstantiationRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionCallParametersCheck $check;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionCallParametersCheck $check, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->check = $check;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\New_::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $errors = [];
        foreach ($this->getClassNames($node, $scope) as [$class, $isName]) {
            $errors = \array_merge($errors, $this->checkClassName($class, $isName, $node, $scope));
        }
        return $errors;
    }
    /**
     * @param string $class
     * @param \PhpParser\Node\Expr\New_ $node
     * @param Scope $scope
     * @return RuleError[]
     */
    private function checkClassName(string $class, bool $isName, \TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $lowercasedClass = \strtolower($class);
        $messages = [];
        $isStatic = \false;
        if ($lowercasedClass === 'static') {
            if (!$scope->isInClass()) {
                return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $class))->build()];
            }
            $isStatic = \true;
            $classReflection = $scope->getClassReflection();
            if (!$classReflection->isFinal()) {
                if (!$classReflection->hasConstructor()) {
                    return [];
                }
                $constructor = $classReflection->getConstructor();
                if (!$constructor->getPrototype()->getDeclaringClass()->isInterface() && $constructor instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodReflection && !$constructor->isFinal()->yes() && !$constructor->getPrototype()->isAbstract()) {
                    return [];
                }
            }
        } elseif ($lowercasedClass === 'self') {
            if (!$scope->isInClass()) {
                return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $class))->build()];
            }
            $classReflection = $scope->getClassReflection();
        } elseif ($lowercasedClass === 'parent') {
            if (!$scope->isInClass()) {
                return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $class))->build()];
            }
            if ($scope->getClassReflection()->getParentClass() === \false) {
                return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s::%s() calls new parent but %s does not extend any class.', $scope->getClassReflection()->getDisplayName(), $scope->getFunctionName(), $scope->getClassReflection()->getDisplayName()))->build()];
            }
            $classReflection = $scope->getClassReflection()->getParentClass();
        } else {
            if (!$this->reflectionProvider->hasClass($class)) {
                if ($scope->isInClassExists($class)) {
                    return [];
                }
                return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instantiated class %s not found.', $class))->discoveringSymbolsTip()->build()];
            } else {
                $messages = $this->classCaseSensitivityCheck->checkClassNames([new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair($class, $node->class)]);
            }
            $classReflection = $this->reflectionProvider->getClass($class);
        }
        if (!$isStatic && $classReflection->isInterface() && $isName) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot instantiate interface %s.', $classReflection->getDisplayName()))->build()];
        }
        if (!$isStatic && $classReflection->isAbstract() && $isName) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instantiated class %s is abstract.', $classReflection->getDisplayName()))->build()];
        }
        if (!$isName) {
            return [];
        }
        if (!$classReflection->hasConstructor()) {
            if (\count($node->args) > 0) {
                return \array_merge($messages, [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Class %s does not have a constructor and must be instantiated without any parameters.', $classReflection->getDisplayName()))->build()]);
            }
            return $messages;
        }
        $constructorReflection = $classReflection->getConstructor();
        if (!$scope->canCallMethod($constructorReflection)) {
            $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot instantiate class %s via %s constructor %s::%s().', $classReflection->getDisplayName(), $constructorReflection->isPrivate() ? 'private' : 'protected', $constructorReflection->getDeclaringClass()->getDisplayName(), $constructorReflection->getName()))->build();
        }
        return \array_merge($messages, $this->check->check(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $node->args, $constructorReflection->getVariants()), $scope, $constructorReflection->getDeclaringClass()->isBuiltin(), $node, [
            'Class ' . $classReflection->getDisplayName() . ' constructor invoked with %d parameter, %d required.',
            'Class ' . $classReflection->getDisplayName() . ' constructor invoked with %d parameters, %d required.',
            'Class ' . $classReflection->getDisplayName() . ' constructor invoked with %d parameter, at least %d required.',
            'Class ' . $classReflection->getDisplayName() . ' constructor invoked with %d parameters, at least %d required.',
            'Class ' . $classReflection->getDisplayName() . ' constructor invoked with %d parameter, %d-%d required.',
            'Class ' . $classReflection->getDisplayName() . ' constructor invoked with %d parameters, %d-%d required.',
            'Parameter %s of class ' . $classReflection->getDisplayName() . ' constructor expects %s, %s given.',
            '',
            // constructor does not have a return type
            'Parameter %s of class ' . $classReflection->getDisplayName() . ' constructor is passed by reference, so it expects variables only',
            'Unable to resolve the template type %s in instantiation of class ' . $classReflection->getDisplayName(),
            'Missing parameter $%s in call to ' . $classReflection->getDisplayName() . ' constructor.',
            'Unknown parameter $%s in call to ' . $classReflection->getDisplayName() . ' constructor.',
        ]));
    }
    /**
     * @param \PhpParser\Node\Expr\New_ $node $node
     * @param Scope $scope
     * @return array<int, array{string, bool}>
     */
    private function getClassNames(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            return [[(string) $node->class, \true]];
        }
        if ($node->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_) {
            $anonymousClassType = $scope->getType($node);
            if (!$anonymousClassType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            return [[$anonymousClassType->getClassName(), \true]];
        }
        $type = $scope->getType($node->class);
        return \array_merge(\array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType $type) : array {
            return [$type->getValue(), \true];
        }, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantStrings($type)), \array_map(static function (string $name) : array {
            return [$name, \false];
        }, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getDirectClassNames($type)));
    }
}
