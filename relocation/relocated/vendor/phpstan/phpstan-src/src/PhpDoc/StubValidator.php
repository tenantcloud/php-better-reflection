<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\FileAnalyser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\DerivativeContainerFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\PhpDocParser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\ExistingClassesInClassImplementsRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\ExistingClassesInInterfaceExtendsRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\ExistingClassInClassExtendsRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\ExistingClassInTraitUseRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionDefinitionCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions\MissingFunctionParameterTypehintRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions\MissingFunctionReturnTypehintRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\ClassAncestorsRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\ClassTemplateTypeRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\FunctionSignatureVarianceRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\FunctionTemplateTypeRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericAncestorsCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\InterfaceAncestorsRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\InterfaceTemplateTypeRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\MethodSignatureVarianceRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\MethodTemplateTypeRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\TemplateTypeCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\TraitTemplateTypeRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\VarianceCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\ExistingClassesInTypehintsRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\MissingMethodParameterTypehintRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\MissingMethodReturnTypehintRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc\IncompatiblePhpDocTypeRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc\IncompatiblePropertyPhpDocTypeRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc\InvalidPhpDocTagValueRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc\InvalidThrowsPhpDocValueRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\ExistingClassesInPropertiesRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\MissingPropertyTypehintRule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Registry;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
class StubValidator
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\DerivativeContainerFactory $derivativeContainerFactory;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\DerivativeContainerFactory $derivativeContainerFactory)
    {
        $this->derivativeContainerFactory = $derivativeContainerFactory;
    }
    /**
     * @param string[] $stubFiles
     * @return \PHPStan\Analyser\Error[]
     */
    public function validate(array $stubFiles) : array
    {
        if (\count($stubFiles) === 0) {
            return [];
        }
        $originalBroker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
        $container = $this->derivativeContainerFactory->create([__DIR__ . '/../../conf/config.stubValidator.neon']);
        $ruleRegistry = $this->getRuleRegistry($container);
        /** @var FileAnalyser $fileAnalyser */
        $fileAnalyser = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\FileAnalyser::class);
        /** @var NodeScopeResolver $nodeScopeResolver */
        $nodeScopeResolver = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver::class);
        $nodeScopeResolver->setAnalysedFiles($stubFiles);
        $analysedFiles = \array_fill_keys($stubFiles, \true);
        $errors = [];
        foreach ($stubFiles as $stubFile) {
            $tmpErrors = $fileAnalyser->analyseFile($stubFile, $analysedFiles, $ruleRegistry, static function () : void {
            })->getErrors();
            foreach ($tmpErrors as $tmpError) {
                $errors[] = $tmpError->withoutTip();
            }
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::registerInstance($originalBroker);
        return $errors;
    }
    private function getRuleRegistry(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container) : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Registry
    {
        $fileTypeMapper = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class);
        $genericObjectTypeCheck = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck::class);
        $genericAncestorsCheck = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericAncestorsCheck::class);
        $templateTypeCheck = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\TemplateTypeCheck::class);
        $varianceCheck = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\VarianceCheck::class);
        $reflectionProvider = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider::class);
        $classCaseSensitivityCheck = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck::class);
        $functionDefinitionCheck = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionDefinitionCheck::class);
        $missingTypehintCheck = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck::class);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Registry([
            // level 0
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\ExistingClassesInClassImplementsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\ExistingClassesInInterfaceExtendsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\ExistingClassInClassExtendsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\ExistingClassInTraitUseRule($classCaseSensitivityCheck, $reflectionProvider),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\ExistingClassesInTypehintsRule($functionDefinitionCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions\ExistingClassesInTypehintsRule($functionDefinitionCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\ExistingClassesInPropertiesRule($reflectionProvider, $classCaseSensitivityCheck, \true, \false),
            // level 2
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\ClassAncestorsRule($fileTypeMapper, $genericAncestorsCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\ClassTemplateTypeRule($templateTypeCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\FunctionTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\FunctionSignatureVarianceRule($varianceCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\InterfaceAncestorsRule($fileTypeMapper, $genericAncestorsCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\InterfaceTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\MethodTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\MethodSignatureVarianceRule($varianceCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\TraitTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc\IncompatiblePhpDocTypeRule($fileTypeMapper, $genericObjectTypeCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc\IncompatiblePropertyPhpDocTypeRule($genericObjectTypeCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc\InvalidPhpDocTagValueRule($container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::class), $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\PhpDocParser::class)),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc\InvalidThrowsPhpDocValueRule($fileTypeMapper),
            // level 6
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions\MissingFunctionParameterTypehintRule($missingTypehintCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions\MissingFunctionReturnTypehintRule($missingTypehintCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\MissingMethodParameterTypehintRule($missingTypehintCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\MissingMethodReturnTypehintRule($missingTypehintCheck),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\MissingPropertyTypehintRule($missingTypehintCheck),
        ]);
    }
}
