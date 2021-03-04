<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\ClassPropertiesNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<ClassPropertiesNode>
 */
class UninitializedPropertyRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider $extensionProvider;
    /** @var string[] */
    private array $additionalConstructors;
    /** @var array<string, string[]> */
    private array $additionalConstructorsCache = [];
    /**
     * @param string[] $additionalConstructors
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider $extensionProvider, array $additionalConstructors)
    {
        $this->extensionProvider = $extensionProvider;
        $this->additionalConstructors = $additionalConstructors;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Node\ClassPropertiesNode::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        [$properties, $prematureAccess] = $node->getUninitializedProperties($scope, $this->getConstructors($classReflection), $this->extensionProvider->getExtensions());
        $errors = [];
        foreach ($properties as $propertyName => $propertyNode) {
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Class %s has an uninitialized property $%s. Give it default value or assign it in the constructor.', $classReflection->getDisplayName(), $propertyName))->line($propertyNode->getLine())->build();
        }
        foreach ($prematureAccess as [$propertyName, $line]) {
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to an uninitialized property %s::$%s.', $classReflection->getDisplayName(), $propertyName))->line($line)->build();
        }
        return $errors;
    }
    /**
     * @param ClassReflection $classReflection
     * @return string[]
     */
    private function getConstructors(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection) : array
    {
        if (\array_key_exists($classReflection->getName(), $this->additionalConstructorsCache)) {
            return $this->additionalConstructorsCache[$classReflection->getName()];
        }
        $constructors = [];
        if ($classReflection->hasConstructor()) {
            $constructors[] = $classReflection->getConstructor()->getName();
        }
        $nativeReflection = $classReflection->getNativeReflection();
        foreach ($this->additionalConstructors as $additionalConstructor) {
            [$className, $methodName] = \explode('::', $additionalConstructor);
            if (!$nativeReflection->hasMethod($methodName)) {
                continue;
            }
            $nativeMethod = $nativeReflection->getMethod($methodName);
            if ($nativeMethod->getDeclaringClass()->getName() !== $nativeReflection->getName()) {
                continue;
            }
            try {
                $prototype = $nativeMethod->getPrototype();
            } catch (\ReflectionException $e) {
                $prototype = $nativeMethod;
            }
            if ($prototype->getDeclaringClass()->getName() !== $className) {
                continue;
            }
            $constructors[] = $methodName;
        }
        $this->additionalConstructorsCache[$classReflection->getName()] = $constructors;
        return $constructors;
    }
}
