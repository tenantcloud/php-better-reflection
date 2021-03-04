<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\FunctionLike;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Param;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflectionWithPhpDocs;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorWithPhpDocs;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NonexistentParentClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType;
class FunctionDefinitionCheck
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion;
    private bool $checkClassCaseSensitivity;
    private bool $checkThisOnly;
    private bool $checkMissingTemplateTypeInParameter;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion, bool $checkClassCaseSensitivity, bool $checkThisOnly, bool $checkMissingTemplateTypeInParameter)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->phpVersion = $phpVersion;
        $this->checkClassCaseSensitivity = $checkClassCaseSensitivity;
        $this->checkThisOnly = $checkThisOnly;
        $this->checkMissingTemplateTypeInParameter = $checkMissingTemplateTypeInParameter;
    }
    /**
     * @param \PhpParser\Node\Stmt\Function_ $function
     * @param string $parameterMessage
     * @param string $returnMessage
     * @param string $unionTypesMessage
     * @param string $templateTypeMissingInParameterMessage
     * @return RuleError[]
     */
    public function checkFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_ $function, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, string $parameterMessage, string $returnMessage, string $unionTypesMessage, string $templateTypeMissingInParameterMessage) : array
    {
        $parametersAcceptor = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants());
        return $this->checkParametersAcceptor($parametersAcceptor, $function, $parameterMessage, $returnMessage, $unionTypesMessage, $templateTypeMissingInParameterMessage);
    }
    /**
     * @param \PHPStan\Analyser\Scope $scope
     * @param \PhpParser\Node\Param[] $parameters
     * @param \PhpParser\Node\Identifier|\PhpParser\Node\Name|\PhpParser\Node\NullableType|\PhpParser\Node\UnionType|null $returnTypeNode
     * @param string $parameterMessage
     * @param string $returnMessage
     * @param string $unionTypesMessage
     * @return \PHPStan\Rules\RuleError[]
     */
    public function checkAnonymousFunction(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, array $parameters, $returnTypeNode, string $parameterMessage, string $returnMessage, string $unionTypesMessage) : array
    {
        $errors = [];
        $unionTypeReported = \false;
        foreach ($parameters as $param) {
            if ($param->type === null) {
                continue;
            }
            if (!$unionTypeReported && $param->type instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\UnionType && !$this->phpVersion->supportsNativeUnionTypes()) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message($unionTypesMessage)->line($param->getLine())->nonIgnorable()->build();
                $unionTypeReported = \true;
            }
            if (!$param->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable || !\is_string($param->var->name)) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $type = $scope->getFunctionType($param->type, \false, \false);
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($parameterMessage, $param->var->name, 'void'))->line($param->type->getLine())->nonIgnorable()->build();
            }
            foreach ($type->getReferencedClasses() as $class) {
                if (!$this->reflectionProvider->hasClass($class) || $this->reflectionProvider->getClass($class)->isTrait()) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($parameterMessage, $param->var->name, $class))->line($param->type->getLine())->build();
                } elseif ($this->checkClassCaseSensitivity) {
                    $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames([new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair($class, $param->type)]));
                }
            }
        }
        if ($this->phpVersion->deprecatesRequiredParameterAfterOptional()) {
            $errors = \array_merge($errors, $this->checkRequiredParameterAfterOptional($parameters));
        }
        if ($returnTypeNode === null) {
            return $errors;
        }
        if (!$unionTypeReported && $returnTypeNode instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\UnionType && !$this->phpVersion->supportsNativeUnionTypes()) {
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message($unionTypesMessage)->line($returnTypeNode->getLine())->nonIgnorable()->build();
        }
        $returnType = $scope->getFunctionType($returnTypeNode, \false, \false);
        foreach ($returnType->getReferencedClasses() as $returnTypeClass) {
            if (!$this->reflectionProvider->hasClass($returnTypeClass) || $this->reflectionProvider->getClass($returnTypeClass)->isTrait()) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($returnMessage, $returnTypeClass))->line($returnTypeNode->getLine())->build();
            } elseif ($this->checkClassCaseSensitivity) {
                $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames([new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair($returnTypeClass, $returnTypeNode)]));
            }
        }
        return $errors;
    }
    /**
     * @param PhpMethodFromParserNodeReflection $methodReflection
     * @param ClassMethod $methodNode
     * @param string $parameterMessage
     * @param string $returnMessage
     * @param string $unionTypesMessage
     * @param string $templateTypeMissingInParameterMessage
     * @return RuleError[]
     */
    public function checkClassMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod $methodNode, string $parameterMessage, string $returnMessage, string $unionTypesMessage, string $templateTypeMissingInParameterMessage) : array
    {
        /** @var \PHPStan\Reflection\ParametersAcceptorWithPhpDocs $parametersAcceptor */
        $parametersAcceptor = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());
        return $this->checkParametersAcceptor($parametersAcceptor, $methodNode, $parameterMessage, $returnMessage, $unionTypesMessage, $templateTypeMissingInParameterMessage);
    }
    /**
     * @param ParametersAcceptor $parametersAcceptor
     * @param FunctionLike $functionNode
     * @param string $parameterMessage
     * @param string $returnMessage
     * @param string $unionTypesMessage
     * @param string $templateTypeMissingInParameterMessage
     * @return RuleError[]
     */
    private function checkParametersAcceptor(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\FunctionLike $functionNode, string $parameterMessage, string $returnMessage, string $unionTypesMessage, string $templateTypeMissingInParameterMessage) : array
    {
        $errors = [];
        $parameterNodes = $functionNode->getParams();
        if (!$this->phpVersion->supportsNativeUnionTypes()) {
            $unionTypeReported = \false;
            foreach ($parameterNodes as $parameterNode) {
                if (!$parameterNode->type instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\UnionType) {
                    continue;
                }
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message($unionTypesMessage)->line($parameterNode->getLine())->nonIgnorable()->build();
                $unionTypeReported = \true;
                break;
            }
            if (!$unionTypeReported && $functionNode->getReturnType() instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\UnionType) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message($unionTypesMessage)->line($functionNode->getReturnType()->getLine())->nonIgnorable()->build();
            }
        }
        if ($this->phpVersion->deprecatesRequiredParameterAfterOptional()) {
            $errors = \array_merge($errors, $this->checkRequiredParameterAfterOptional($parameterNodes));
        }
        $returnTypeNode = $functionNode->getReturnType() ?? $functionNode;
        foreach ($parametersAcceptor->getParameters() as $parameter) {
            $referencedClasses = $this->getParameterReferencedClasses($parameter);
            $parameterNode = null;
            $parameterNodeCallback = function () use($parameter, $parameterNodes, &$parameterNode) : Param {
                if ($parameterNode === null) {
                    $parameterNode = $this->getParameterNode($parameter->getName(), $parameterNodes);
                }
                return $parameterNode;
            };
            if ($parameter instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflectionWithPhpDocs && $parameter->getNativeType() instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType) {
                $parameterVar = $parameterNodeCallback()->var;
                if (!$parameterVar instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable || !\is_string($parameterVar->name)) {
                    throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                }
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($parameterMessage, $parameterVar->name, 'void'))->line($parameterNodeCallback()->getLine())->nonIgnorable()->build();
            }
            foreach ($referencedClasses as $class) {
                if ($this->reflectionProvider->hasClass($class) && !$this->reflectionProvider->getClass($class)->isTrait()) {
                    continue;
                }
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($parameterMessage, $parameter->getName(), $class))->line($parameterNodeCallback()->getLine())->build();
            }
            if ($this->checkClassCaseSensitivity) {
                $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (string $class) use($parameterNodeCallback) : ClassNameNodePair {
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair($class, $parameterNodeCallback());
                }, $referencedClasses)));
            }
            if (!$parameter->getType() instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NonexistentParentClassType) {
                continue;
            }
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($parameterMessage, $parameter->getName(), $parameter->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->line($parameterNodeCallback()->getLine())->build();
        }
        $returnTypeReferencedClasses = $this->getReturnTypeReferencedClasses($parametersAcceptor);
        foreach ($returnTypeReferencedClasses as $class) {
            if ($this->reflectionProvider->hasClass($class) && !$this->reflectionProvider->getClass($class)->isTrait()) {
                continue;
            }
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($returnMessage, $class))->line($returnTypeNode->getLine())->build();
        }
        if ($this->checkClassCaseSensitivity) {
            $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (string $class) use($returnTypeNode) : ClassNameNodePair {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair($class, $returnTypeNode);
            }, $returnTypeReferencedClasses)));
        }
        if ($parametersAcceptor->getReturnType() instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NonexistentParentClassType) {
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($returnMessage, $parametersAcceptor->getReturnType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->line($returnTypeNode->getLine())->build();
        }
        if ($this->checkMissingTemplateTypeInParameter) {
            $templateTypeMap = $parametersAcceptor->getTemplateTypeMap();
            $templateTypes = $templateTypeMap->getTypes();
            if (\count($templateTypes) > 0) {
                foreach ($parametersAcceptor->getParameters() as $parameter) {
                    \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($parameter->getType(), static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) use(&$templateTypes) : Type {
                        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                            unset($templateTypes[$type->getName()]);
                            return $type;
                        }
                        return $traverse($type);
                    });
                }
                foreach (\array_keys($templateTypes) as $templateTypeName) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($templateTypeMissingInParameterMessage, $templateTypeName))->build();
                }
            }
        }
        return $errors;
    }
    /**
     * @param Param[] $parameterNodes
     * @return RuleError[]
     */
    private function checkRequiredParameterAfterOptional(array $parameterNodes) : array
    {
        /** @var string|null $optionalParameter */
        $optionalParameter = null;
        $errors = [];
        foreach ($parameterNodes as $parameterNode) {
            if (!$parameterNode->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            if (!\is_string($parameterNode->var->name)) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $parameterName = $parameterNode->var->name;
            if ($optionalParameter !== null && $parameterNode->default === null && !$parameterNode->variadic) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Deprecated in PHP 8.0: Required parameter $%s follows optional parameter $%s.', $parameterName, $optionalParameter))->line($parameterNode->getStartLine())->nonIgnorable()->build();
                continue;
            }
            if ($parameterNode->default === null) {
                continue;
            }
            if ($parameterNode->type === null) {
                $optionalParameter = $parameterName;
                continue;
            }
            $defaultValue = $parameterNode->default;
            if (!$defaultValue instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch) {
                $optionalParameter = $parameterName;
                continue;
            }
            $constantName = $defaultValue->name->toLowerString();
            if ($constantName === 'null') {
                continue;
            }
            $optionalParameter = $parameterName;
        }
        return $errors;
    }
    /**
     * @param string $parameterName
     * @param Param[] $parameterNodes
     * @return Param
     */
    private function getParameterNode(string $parameterName, array $parameterNodes) : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Param
    {
        foreach ($parameterNodes as $param) {
            if ($param->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Error) {
                continue;
            }
            if (!\is_string($param->var->name)) {
                continue;
            }
            if ($param->var->name === $parameterName) {
                return $param;
            }
        }
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException(\sprintf('Parameter %s not found.', $parameterName));
    }
    /**
     * @param \PHPStan\Reflection\ParameterReflection $parameter
     * @return string[]
     */
    private function getParameterReferencedClasses(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflection $parameter) : array
    {
        if (!$parameter instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflectionWithPhpDocs) {
            return $parameter->getType()->getReferencedClasses();
        }
        if ($this->checkThisOnly) {
            return $parameter->getNativeType()->getReferencedClasses();
        }
        return \array_merge($parameter->getNativeType()->getReferencedClasses(), $parameter->getPhpDocType()->getReferencedClasses());
    }
    /**
     * @param \PHPStan\Reflection\ParametersAcceptor $parametersAcceptor
     * @return string[]
     */
    private function getReturnTypeReferencedClasses(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor) : array
    {
        if (!$parametersAcceptor instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorWithPhpDocs) {
            return $parametersAcceptor->getReturnType()->getReferencedClasses();
        }
        if ($this->checkThisOnly) {
            return $parametersAcceptor->getNativeReturnType()->getReferencedClasses();
        }
        return \array_merge($parametersAcceptor->getNativeReturnType()->getReferencedClasses(), $parametersAcceptor->getPhpDocReturnType()->getReferencedClasses());
    }
}
