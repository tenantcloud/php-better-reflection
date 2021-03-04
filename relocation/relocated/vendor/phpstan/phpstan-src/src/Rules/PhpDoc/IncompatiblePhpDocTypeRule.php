<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\FunctionLike>
 */
class IncompatiblePhpDocTypeRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->genericObjectTypeCheck = $genericObjectTypeCheck;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\FunctionLike::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $functionName = null;
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod) {
            $functionName = $node->name->name;
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_) {
            $functionName = \trim($scope->getNamespace() . '\\' . $node->name->name, '\\');
        }
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $scope->isInClass() ? $scope->getClassReflection()->getName() : null, $scope->isInTrait() ? $scope->getTraitReflection()->getName() : null, $functionName, $docComment->getText());
        $nativeParameterTypes = $this->getNativeParameterTypes($node, $scope);
        $nativeReturnType = $this->getNativeReturnType($node, $scope);
        $errors = [];
        foreach ($resolvedPhpDoc->getParamTags() as $parameterName => $phpDocParamTag) {
            $phpDocParamType = $phpDocParamTag->getType();
            if (!isset($nativeParameterTypes[$parameterName])) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @param references unknown parameter: $%s', $parameterName))->identifier('phpDoc.unknownParameter')->metadata(['parameterName' => $parameterName])->build();
            } elseif ($phpDocParamType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType || $phpDocParamType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType && !$phpDocParamType->isExplicit()) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @param for parameter $%s contains unresolvable type.', $parameterName))->build();
            } else {
                $nativeParamType = $nativeParameterTypes[$parameterName];
                if ($phpDocParamTag->isVariadic() && $phpDocParamType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType && !$nativeParamType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
                    $phpDocParamType = $phpDocParamType->getItemType();
                }
                $isParamSuperType = $nativeParamType->isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($phpDocParamType));
                $errors = \array_merge($errors, $this->genericObjectTypeCheck->check($phpDocParamType, \sprintf('PHPDoc tag @param for parameter $%s contains generic type %%s but class %%s is not generic.', $parameterName), \sprintf('Generic type %%s in PHPDoc tag @param for parameter $%s does not specify all template types of class %%s: %%s', $parameterName), \sprintf('Generic type %%s in PHPDoc tag @param for parameter $%s specifies %%d template types, but class %%s supports only %%d: %%s', $parameterName), \sprintf('Type %%s in generic type %%s in PHPDoc tag @param for parameter $%s is not subtype of template type %%s of class %%s.', $parameterName)));
                if ($isParamSuperType->no()) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @param for parameter $%s with type %s is incompatible with native type %s.', $parameterName, $phpDocParamType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeParamType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                } elseif ($isParamSuperType->maybe()) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @param for parameter $%s with type %s is not subtype of native type %s.', $parameterName, $phpDocParamType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeParamType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                }
            }
        }
        if ($resolvedPhpDoc->getReturnTag() !== null) {
            $phpDocReturnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($resolvedPhpDoc->getReturnTag()->getType());
            if ($phpDocReturnType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType || $phpDocReturnType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType && !$phpDocReturnType->isExplicit()) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('PHPDoc tag @return contains unresolvable type.')->build();
            } else {
                $isReturnSuperType = $nativeReturnType->isSuperTypeOf($phpDocReturnType);
                $errors = \array_merge($errors, $this->genericObjectTypeCheck->check($phpDocReturnType, 'PHPDoc tag @return contains generic type %s but class %s is not generic.', 'Generic type %s in PHPDoc tag @return does not specify all template types of class %s: %s', 'Generic type %s in PHPDoc tag @return specifies %d template types, but class %s supports only %d: %s', 'Type %s in generic type %s in PHPDoc tag @return is not subtype of template type %s of class %s.'));
                if ($isReturnSuperType->no()) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @return with type %s is incompatible with native type %s.', $phpDocReturnType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeReturnType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                } elseif ($isReturnSuperType->maybe()) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @return with type %s is not subtype of native type %s.', $phpDocReturnType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeReturnType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                }
            }
        }
        return $errors;
    }
    /**
     * @param Node\FunctionLike $node
     * @param Scope $scope
     * @return Type[]
     */
    private function getNativeParameterTypes(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\FunctionLike $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $nativeParameterTypes = [];
        foreach ($node->getParams() as $parameter) {
            $isNullable = $scope->isParameterValueNullable($parameter);
            if (!$parameter->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable || !\is_string($parameter->var->name)) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $nativeParameterTypes[$parameter->var->name] = $scope->getFunctionType($parameter->type, $isNullable, \false);
        }
        return $nativeParameterTypes;
    }
    private function getNativeReturnType(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\FunctionLike $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $scope->getFunctionType($node->getReturnType(), \false, \false);
    }
}
