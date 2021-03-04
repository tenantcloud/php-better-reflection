<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class GenericObjectTypeCheck
{
    /**
     * @param \PHPStan\Type\Type $phpDocType
     * @param string $classNotGenericMessage
     * @param string $notEnoughTypesMessage
     * @param string $extraTypesMessage
     * @param string $typeIsNotSubtypeMessage
     * @return \PHPStan\Rules\RuleError[]
     */
    public function check(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocType, string $classNotGenericMessage, string $notEnoughTypesMessage, string $extraTypesMessage, string $typeIsNotSubtypeMessage) : array
    {
        $genericTypes = $this->getGenericTypes($phpDocType);
        $messages = [];
        foreach ($genericTypes as $genericType) {
            $classReflection = $genericType->getClassReflection();
            if ($classReflection === null) {
                continue;
            }
            if (!$classReflection->isGeneric()) {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($classNotGenericMessage, $genericType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName()))->build();
                continue;
            }
            $templateTypes = \array_values($classReflection->getTemplateTypeMap()->getTypes());
            $genericTypeTypes = $genericType->getTypes();
            $templateTypesCount = \count($templateTypes);
            $genericTypeTypesCount = \count($genericTypeTypes);
            if ($templateTypesCount > $genericTypeTypesCount) {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($notEnoughTypesMessage, $genericType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName(\false), \implode(', ', \array_keys($classReflection->getTemplateTypeMap()->getTypes()))))->build();
            } elseif ($templateTypesCount < $genericTypeTypesCount) {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($extraTypesMessage, $genericType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $genericTypeTypesCount, $classReflection->getDisplayName(\false), $templateTypesCount, \implode(', ', \array_keys($classReflection->getTemplateTypeMap()->getTypes()))))->build();
            }
            foreach ($templateTypes as $i => $templateType) {
                if (!isset($genericTypeTypes[$i])) {
                    continue;
                }
                $boundType = $templateType;
                if ($templateType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                    $boundType = $templateType->getBound();
                }
                $genericTypeType = $genericTypeTypes[$i];
                if ($boundType->isSuperTypeOf($genericTypeType)->yes()) {
                    continue;
                }
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($typeIsNotSubtypeMessage, $genericTypeType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $genericType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $templateType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName(\false)))->build();
            }
        }
        return $messages;
    }
    /**
     * @param \PHPStan\Type\Type $phpDocType
     * @return \PHPStan\Type\Generic\GenericObjectType[]
     */
    private function getGenericTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocType) : array
    {
        $genericObjectTypes = [];
        \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($phpDocType, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) use(&$genericObjectTypes) : Type {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType) {
                $resolvedType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($type);
                if (!$resolvedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType) {
                    throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                }
                $genericObjectTypes[] = $resolvedType;
                $traverse($type);
                return $type;
            }
            $traverse($type);
            return $type;
        });
        return $genericObjectTypes;
    }
}
