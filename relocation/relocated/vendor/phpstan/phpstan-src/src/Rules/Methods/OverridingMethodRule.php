<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\InClassMethodNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariantWithPhpDocs;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodPrototypeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflectionWithPhpDocs;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
use function array_slice;
/**
 * @implements Rule<InClassMethodNode>
 */
class OverridingMethodRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\MethodSignatureRule $methodSignatureRule;
    private bool $checkPhpDocMethodSignatures;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\MethodSignatureRule $methodSignatureRule, bool $checkPhpDocMethodSignatures)
    {
        $this->phpVersion = $phpVersion;
        $this->methodSignatureRule = $methodSignatureRule;
        $this->checkPhpDocMethodSignatures = $checkPhpDocMethodSignatures;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $method = $scope->getFunction();
        if (!$method instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $prototype = $method->getPrototype();
        if ($prototype->getDeclaringClass()->getName() === $method->getDeclaringClass()->getName()) {
            if (\strtolower($method->getName()) === '__construct') {
                $parent = $method->getDeclaringClass()->getParentClass();
                if ($parent !== \false && $parent->hasConstructor()) {
                    $parentConstructor = $parent->getConstructor();
                    if ($parentConstructor->isFinal()->yes()) {
                        return $this->addErrors([\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() overrides final method %s::%s().', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $parent->getDisplayName(), $parentConstructor->getName()))->nonIgnorable()->build()], $node, $scope);
                    }
                }
            }
            return [];
        }
        if (!$prototype instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodPrototypeReflection) {
            return [];
        }
        $messages = [];
        if ($prototype->isFinal()) {
            $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() overrides final method %s::%s().', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
        }
        if ($prototype->isStatic()) {
            if (!$method->isStatic()) {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Non-static method %s::%s() overrides static method %s::%s().', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            }
        } elseif ($method->isStatic()) {
            $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Static method %s::%s() overrides non-static method %s::%s().', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
        }
        if ($prototype->isPublic()) {
            if (!$method->isPublic()) {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s method %s::%s() overriding public method %s::%s() should also be public.', $method->isPrivate() ? 'Private' : 'Protected', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            }
        } elseif ($method->isPrivate()) {
            $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Private method %s::%s() overriding protected method %s::%s() should be protected or public.', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
        }
        $prototypeVariants = $prototype->getVariants();
        if (\count($prototypeVariants) !== 1) {
            return $this->addErrors($messages, $node, $scope);
        }
        $prototypeVariant = $prototypeVariants[0];
        $methodVariant = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants());
        $methodParameters = $methodVariant->getParameters();
        $prototypeAfterVariadic = \false;
        foreach ($prototypeVariant->getParameters() as $i => $prototypeParameter) {
            if (!\array_key_exists($i, $methodParameters)) {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() overrides method %s::%s() but misses parameter #%d $%s.', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName(), $i + 1, $prototypeParameter->getName()))->nonIgnorable()->build();
                continue;
            }
            $methodParameter = $methodParameters[$i];
            if ($prototypeParameter->passedByReference()->no()) {
                if (!$methodParameter->passedByReference()->no()) {
                    $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is passed by reference but parameter #%d $%s of method %s::%s() is not passed by reference.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
                }
            } elseif ($methodParameter->passedByReference()->no()) {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is not passed by reference but parameter #%d $%s of method %s::%s() is passed by reference.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            }
            if ($prototypeParameter->isVariadic()) {
                $prototypeAfterVariadic = \true;
                if (!$methodParameter->isVariadic()) {
                    if (!$methodParameter->isOptional()) {
                        if (\count($methodParameters) !== $i + 1) {
                            $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is not optional.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName()))->nonIgnorable()->build();
                            continue;
                        }
                        $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is not variadic but parameter #%d $%s of method %s::%s() is variadic.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
                        continue;
                    } elseif (\count($methodParameters) === $i + 1) {
                        $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is not variadic.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName()))->nonIgnorable()->build();
                    }
                }
            } elseif ($methodParameter->isVariadic()) {
                if ($this->phpVersion->supportsLessOverridenParametersWithVariadic()) {
                    $remainingPrototypeParameters = \array_slice($prototypeVariant->getParameters(), $i);
                    foreach ($remainingPrototypeParameters as $j => $remainingPrototypeParameter) {
                        if (!$remainingPrototypeParameter instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflectionWithPhpDocs) {
                            continue;
                        }
                        if ($methodParameter->getNativeType()->isSuperTypeOf($remainingPrototypeParameter->getNativeType())->yes()) {
                            continue;
                        }
                        $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d ...$%s (%s) of method %s::%s() is not contravariant with parameter #%d $%s (%s) of method %s::%s().', $i + 1, $methodParameter->getName(), $methodParameter->getNativeType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + $j + 1, $remainingPrototypeParameter->getName(), $remainingPrototypeParameter->getNativeType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
                    }
                    break;
                }
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is variadic but parameter #%d $%s of method %s::%s() is not variadic.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
                continue;
            }
            if ($prototypeParameter->isOptional() && !$methodParameter->isOptional()) {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is required but parameter #%d $%s of method %s::%s() is optional.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            }
            $methodParameterType = $methodParameter->getNativeType();
            if (!$prototypeParameter instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflectionWithPhpDocs) {
                continue;
            }
            $prototypeParameterType = $prototypeParameter->getNativeType();
            if (!$this->phpVersion->supportsParameterTypeWidening()) {
                if (!$methodParameterType->equals($prototypeParameterType)) {
                    $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s (%s) of method %s::%s() does not match parameter #%d $%s (%s) of method %s::%s().', $i + 1, $methodParameter->getName(), $methodParameterType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototypeParameterType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
                }
                continue;
            }
            if ($this->isTypeCompatible($methodParameterType, $prototypeParameterType, $this->phpVersion->supportsParameterContravariance())) {
                continue;
            }
            if ($this->phpVersion->supportsParameterContravariance()) {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s (%s) of method %s::%s() is not contravariant with parameter #%d $%s (%s) of method %s::%s().', $i + 1, $methodParameter->getName(), $methodParameterType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototypeParameterType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            } else {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s (%s) of method %s::%s() is not compatible with parameter #%d $%s (%s) of method %s::%s().', $i + 1, $methodParameter->getName(), $methodParameterType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototypeParameterType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            }
        }
        if (!isset($i)) {
            $i = -1;
        }
        foreach ($methodParameters as $j => $methodParameter) {
            if ($j <= $i) {
                continue;
            }
            if ($j === \count($methodParameters) - 1 && $prototypeAfterVariadic && !$methodParameter->isVariadic()) {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is not variadic.', $j + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName()))->nonIgnorable()->build();
                continue;
            }
            if (!$methodParameter->isOptional()) {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is not optional.', $j + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName()))->nonIgnorable()->build();
                continue;
            }
        }
        $methodReturnType = $methodVariant->getNativeReturnType();
        if (!$prototypeVariant instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariantWithPhpDocs) {
            return $this->addErrors($messages, $node, $scope);
        }
        $prototypeReturnType = $prototypeVariant->getNativeReturnType();
        if (!$this->isTypeCompatible($prototypeReturnType, $methodReturnType, $this->phpVersion->supportsReturnCovariance())) {
            if ($this->phpVersion->supportsReturnCovariance()) {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Return type %s of method %s::%s() is not covariant with return type %s of method %s::%s().', $methodReturnType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototypeReturnType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            } else {
                $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Return type %s of method %s::%s() is not compatible with return type %s of method %s::%s().', $methodReturnType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototypeReturnType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            }
        }
        return $this->addErrors($messages, $node, $scope);
    }
    private function isTypeCompatible(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $methodParameterType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $prototypeParameterType, bool $supportsContravariance) : bool
    {
        if ($methodParameterType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
            return \true;
        }
        if (!$supportsContravariance) {
            if (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::containsNull($methodParameterType)) {
                $prototypeParameterType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::removeNull($prototypeParameterType);
            }
            $methodParameterType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::removeNull($methodParameterType);
            if ($methodParameterType->equals($prototypeParameterType)) {
                return \true;
            }
            if ($methodParameterType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType) {
                if ($prototypeParameterType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
                    return \true;
                }
                if ($prototypeParameterType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType && $prototypeParameterType->getClassName() === \Traversable::class) {
                    return \true;
                }
            }
            return \false;
        }
        return $methodParameterType->isSuperTypeOf($prototypeParameterType)->yes();
    }
    /**
     * @param RuleError[] $errors
     * @return (string|RuleError)[]
     */
    private function addErrors(array $errors, \TenantCloud\BetterReflection\Relocated\PHPStan\Node\InClassMethodNode $classMethod, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (\count($errors) > 0) {
            return $errors;
        }
        if (!$this->checkPhpDocMethodSignatures) {
            return $errors;
        }
        return $this->methodSignatureRule->processNode($classMethod, $scope);
    }
}
