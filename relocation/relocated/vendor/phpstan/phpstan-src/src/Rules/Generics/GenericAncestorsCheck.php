<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class GenericAncestorsCheck
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\VarianceCheck $varianceCheck;
    private bool $checkGenericClassInNonGenericObjectType;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\VarianceCheck $varianceCheck, bool $checkGenericClassInNonGenericObjectType)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->genericObjectTypeCheck = $genericObjectTypeCheck;
        $this->varianceCheck = $varianceCheck;
        $this->checkGenericClassInNonGenericObjectType = $checkGenericClassInNonGenericObjectType;
    }
    /**
     * @param array<\PhpParser\Node\Name> $nameNodes
     * @param array<\PHPStan\Type\Type> $ancestorTypes
     * @return \PHPStan\Rules\RuleError[]
     */
    public function check(array $nameNodes, array $ancestorTypes, string $incompatibleTypeMessage, string $noNamesMessage, string $noRelatedNameMessage, string $classNotGenericMessage, string $notEnoughTypesMessage, string $extraTypesMessage, string $typeIsNotSubtypeMessage, string $invalidTypeMessage, string $genericClassInNonGenericObjectType, string $invalidVarianceMessage) : array
    {
        $names = \array_fill_keys(\array_map(static function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode) : string {
            return $nameNode->toString();
        }, $nameNodes), \true);
        $unusedNames = $names;
        $messages = [];
        foreach ($ancestorTypes as $ancestorType) {
            if (!$ancestorType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType) {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($incompatibleTypeMessage, $ancestorType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                continue;
            }
            $ancestorTypeClassName = $ancestorType->getClassName();
            if (!isset($names[$ancestorTypeClassName])) {
                if (\count($names) === 0) {
                    $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message($noNamesMessage)->build();
                } else {
                    $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($noRelatedNameMessage, $ancestorTypeClassName, \implode(', ', \array_keys($names))))->build();
                }
                continue;
            }
            unset($unusedNames[$ancestorTypeClassName]);
            $genericObjectTypeCheckMessages = $this->genericObjectTypeCheck->check($ancestorType, $classNotGenericMessage, $notEnoughTypesMessage, $extraTypesMessage, $typeIsNotSubtypeMessage);
            $messages = \array_merge($messages, $genericObjectTypeCheckMessages);
            foreach ($ancestorType->getReferencedClasses() as $referencedClass) {
                if ($this->reflectionProvider->hasClass($referencedClass) && !$this->reflectionProvider->getClass($referencedClass)->isTrait()) {
                    continue;
                }
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($invalidTypeMessage, $referencedClass))->build();
            }
            $variance = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant();
            $messageContext = \sprintf($invalidVarianceMessage, $ancestorType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()));
            foreach ($this->varianceCheck->check($variance, $ancestorType, $messageContext) as $message) {
                $messages[] = $message;
            }
        }
        if ($this->checkGenericClassInNonGenericObjectType) {
            foreach (\array_keys($unusedNames) as $unusedName) {
                if (!$this->reflectionProvider->hasClass($unusedName)) {
                    continue;
                }
                $unusedNameClassReflection = $this->reflectionProvider->getClass($unusedName);
                if (!$unusedNameClassReflection->isGeneric()) {
                    continue;
                }
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($genericClassInNonGenericObjectType, $unusedName, \implode(', ', \array_keys($unusedNameClassReflection->getTemplateTypeMap()->getTypes()))))->tip(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
            }
        }
        return $messages;
    }
}
