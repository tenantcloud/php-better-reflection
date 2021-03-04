<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedFunctionVariant;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType;
class FunctionCallParametersCheck
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NullsafeCheck $nullsafeCheck;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion;
    private bool $checkArgumentTypes;
    private bool $checkArgumentsPassedByReference;
    private bool $checkExtraArguments;
    private bool $checkMissingTypehints;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NullsafeCheck $nullsafeCheck, \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion, bool $checkArgumentTypes, bool $checkArgumentsPassedByReference, bool $checkExtraArguments, bool $checkMissingTypehints)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->nullsafeCheck = $nullsafeCheck;
        $this->phpVersion = $phpVersion;
        $this->checkArgumentTypes = $checkArgumentTypes;
        $this->checkArgumentsPassedByReference = $checkArgumentsPassedByReference;
        $this->checkExtraArguments = $checkExtraArguments;
        $this->checkMissingTypehints = $checkMissingTypehints;
    }
    /**
     * @param \PHPStan\Reflection\ParametersAcceptor $parametersAcceptor
     * @param \PHPStan\Analyser\Scope $scope
     * @param \PhpParser\Node\Expr\FuncCall|\PhpParser\Node\Expr\MethodCall|\PhpParser\Node\Expr\StaticCall|\PhpParser\Node\Expr\New_ $funcCall
     * @param array{string, string, string, string, string, string, string, string, string, string, string, string} $messages
     * @return RuleError[]
     */
    public function check(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, bool $isBuiltin, $funcCall, array $messages) : array
    {
        $functionParametersMinCount = 0;
        $functionParametersMaxCount = 0;
        foreach ($parametersAcceptor->getParameters() as $parameter) {
            if (!$parameter->isOptional()) {
                $functionParametersMinCount++;
            }
            $functionParametersMaxCount++;
        }
        if ($parametersAcceptor->isVariadic()) {
            $functionParametersMaxCount = -1;
        }
        /** @var array<int, array{Expr, Type, bool, string|null, int}> $arguments */
        $arguments = [];
        /** @var array<int, \PhpParser\Node\Arg> $args */
        $args = $funcCall->args;
        $hasNamedArguments = \false;
        $hasUnpackedArgument = \false;
        $errors = [];
        foreach ($args as $i => $arg) {
            $type = $scope->getType($arg->value);
            if ($hasNamedArguments && $arg->unpack) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Named argument cannot be followed by an unpacked (...) argument.')->line($arg->getLine())->nonIgnorable()->build();
            }
            if ($hasUnpackedArgument && !$arg->unpack) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Unpacked argument (...) cannot be followed by a non-unpacked argument.')->line($arg->getLine())->nonIgnorable()->build();
            }
            if ($arg->unpack) {
                $hasUnpackedArgument = \true;
            }
            $argumentName = null;
            if ($arg->name !== null) {
                $hasNamedArguments = \true;
                $argumentName = $arg->name->toString();
            }
            if ($arg->unpack) {
                $arrays = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantArrays($type);
                if (\count($arrays) > 0) {
                    $minKeys = null;
                    foreach ($arrays as $array) {
                        $keysCount = \count($array->getKeyTypes());
                        if ($minKeys !== null && $keysCount >= $minKeys) {
                            continue;
                        }
                        $minKeys = $keysCount;
                    }
                    for ($j = 0; $j < $minKeys; $j++) {
                        $types = [];
                        $commonKey = null;
                        foreach ($arrays as $constantArray) {
                            $types[] = $constantArray->getValueTypes()[$j];
                            $keyType = $constantArray->getKeyTypes()[$j];
                            if ($commonKey === null) {
                                $commonKey = $keyType->getValue();
                            } elseif ($commonKey !== $keyType->getValue()) {
                                $commonKey = \false;
                            }
                        }
                        $keyArgumentName = null;
                        if (\is_string($commonKey)) {
                            $keyArgumentName = $commonKey;
                            $hasNamedArguments = \true;
                        }
                        $arguments[] = [$arg->value, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$types), \false, $keyArgumentName, $arg->getLine()];
                    }
                } else {
                    $arguments[] = [$arg->value, $type->getIterableValueType(), \true, null, $arg->getLine()];
                }
                continue;
            }
            $arguments[] = [$arg->value, $type, \false, $argumentName, $arg->getLine()];
        }
        if ($hasNamedArguments && !$this->phpVersion->supportsNamedArguments()) {
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Named arguments are supported only on PHP 8.0 and later.')->line($funcCall->getLine())->nonIgnorable()->build();
        }
        if (!$hasNamedArguments) {
            $invokedParametersCount = \count($arguments);
            foreach ($arguments as $i => [$argumentValue, $argumentValueType, $unpack, $argumentName]) {
                if ($unpack) {
                    $invokedParametersCount = \max($functionParametersMinCount, $functionParametersMaxCount);
                    break;
                }
            }
            if ($invokedParametersCount < $functionParametersMinCount || $this->checkExtraArguments && $invokedParametersCount > $functionParametersMaxCount) {
                if ($functionParametersMinCount === $functionParametersMaxCount) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($invokedParametersCount === 1 ? $messages[0] : $messages[1], $invokedParametersCount, $functionParametersMinCount))->line($funcCall->getLine())->build();
                } elseif ($functionParametersMaxCount === -1 && $invokedParametersCount < $functionParametersMinCount) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($invokedParametersCount === 1 ? $messages[2] : $messages[3], $invokedParametersCount, $functionParametersMinCount))->line($funcCall->getLine())->build();
                } elseif ($functionParametersMaxCount !== -1) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($invokedParametersCount === 1 ? $messages[4] : $messages[5], $invokedParametersCount, $functionParametersMinCount, $functionParametersMaxCount))->line($funcCall->getLine())->build();
                }
            }
        }
        if ($scope->getType($funcCall) instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType && !$scope->isInFirstLevelStatement() && !$funcCall instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\New_) {
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message($messages[7])->line($funcCall->getLine())->build();
        }
        [$addedErrors, $argumentsWithParameters] = $this->processArguments($parametersAcceptor, $funcCall->getLine(), $isBuiltin, $arguments, $hasNamedArguments, $messages[10], $messages[11]);
        foreach ($addedErrors as $error) {
            $errors[] = $error;
        }
        if (!$this->checkArgumentTypes && !$this->checkArgumentsPassedByReference) {
            return $errors;
        }
        foreach ($argumentsWithParameters as $i => [$argumentValue, $argumentValueType, $unpack, $argumentName, $argumentLine, $parameter]) {
            if ($this->checkArgumentTypes && $unpack) {
                $iterableTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $argumentValue, '', static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool {
                    return $type->isIterable()->yes();
                });
                $iterableTypeResultType = $iterableTypeResult->getType();
                if (!$iterableTypeResultType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType && !$iterableTypeResultType->isIterable()->yes()) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Only iterables can be unpacked, %s given in argument #%d.', $iterableTypeResultType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $i + 1))->line($argumentLine)->build();
                }
            }
            if ($parameter === null) {
                continue;
            }
            $parameterType = $parameter->getType();
            if ($this->checkArgumentTypes && !$parameter->passedByReference()->createsNewVariable() && !$this->ruleLevelHelper->accepts($parameterType, $argumentValueType, $scope->isDeclareStrictTypes())) {
                $verbosityLevel = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($parameterType, $argumentValueType);
                $parameterDescription = \sprintf('%s$%s', $parameter->isVariadic() ? '...' : '', $parameter->getName());
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messages[6], $argumentName === null ? \sprintf('#%d %s', $i + 1, $parameterDescription) : $parameterDescription, $parameterType->describe($verbosityLevel), $argumentValueType->describe($verbosityLevel)))->line($argumentLine)->build();
            }
            if (!$this->checkArgumentsPassedByReference || !$parameter->passedByReference()->yes()) {
                continue;
            }
            if ($this->nullsafeCheck->containsNullSafe($argumentValue)) {
                $parameterDescription = \sprintf('%s$%s', $parameter->isVariadic() ? '...' : '', $parameter->getName());
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messages[8], $argumentName === null ? \sprintf('#%d %s', $i + 1, $parameterDescription) : $parameterDescription))->line($argumentLine)->build();
                continue;
            }
            if ($argumentValue instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable || $argumentValue instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch || $argumentValue instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch || $argumentValue instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch) {
                continue;
            }
            $parameterDescription = \sprintf('%s$%s', $parameter->isVariadic() ? '...' : '', $parameter->getName());
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messages[8], $argumentName === null ? \sprintf('#%d %s', $i + 1, $parameterDescription) : $parameterDescription))->line($argumentLine)->build();
        }
        if ($this->checkMissingTypehints && $parametersAcceptor instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedFunctionVariant) {
            $originalParametersAcceptor = $parametersAcceptor->getOriginalParametersAcceptor();
            $resolvedTypes = $parametersAcceptor->getResolvedTemplateTypeMap()->getTypes();
            if (\count($resolvedTypes) > 0) {
                $returnTemplateTypes = [];
                \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($originalParametersAcceptor->getReturnType(), static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) use(&$returnTemplateTypes) : Type {
                    if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                        $returnTemplateTypes[$type->getName()] = \true;
                        return $type;
                    }
                    return $traverse($type);
                });
                $parameterTemplateTypes = [];
                foreach ($originalParametersAcceptor->getParameters() as $parameter) {
                    \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($parameter->getType(), static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) use(&$parameterTemplateTypes) : Type {
                        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                            $parameterTemplateTypes[$type->getName()] = \true;
                            return $type;
                        }
                        return $traverse($type);
                    });
                }
                foreach ($resolvedTypes as $name => $type) {
                    if (!$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType && (!$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType || $type->isExplicit())) {
                        continue;
                    }
                    if (!\array_key_exists($name, $returnTemplateTypes)) {
                        continue;
                    }
                    if (!\array_key_exists($name, $parameterTemplateTypes)) {
                        continue;
                    }
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messages[9], $name))->line($funcCall->getLine())->tip('See: https://phpstan.org/blog/solving-phpstan-error-unable-to-resolve-template-type')->build();
                }
            }
        }
        return $errors;
    }
    /**
     * @param ParametersAcceptor $parametersAcceptor
     * @param array<int, array{Expr, Type, bool, string|null, int}> $arguments
     * @param bool $hasNamedArguments
     * @param string $missingParameterMessage
     * @param string $unknownParameterMessage
     * @return array{RuleError[], array<int, array{Expr, Type, bool, string|null, int, \PHPStan\Reflection\ParameterReflection|null}>}
     */
    private function processArguments(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor, int $line, bool $isBuiltin, array $arguments, bool $hasNamedArguments, string $missingParameterMessage, string $unknownParameterMessage) : array
    {
        $parameters = $parametersAcceptor->getParameters();
        $parametersByName = [];
        $unusedParametersByName = [];
        $errors = [];
        foreach ($parametersAcceptor->getParameters() as $parameter) {
            $parametersByName[$parameter->getName()] = $parameter;
            if ($parameter->isVariadic()) {
                continue;
            }
            $unusedParametersByName[$parameter->getName()] = $parameter;
        }
        $newArguments = [];
        $namedArgumentAlreadyOccurred = \false;
        foreach ($arguments as $i => [$argumentValue, $argumentValueType, $unpack, $argumentName, $argumentLine]) {
            if ($argumentName === null) {
                if (!isset($parameters[$i])) {
                    if (!$parametersAcceptor->isVariadic() || \count($parameters) === 0) {
                        $newArguments[$i] = [$argumentValue, $argumentValueType, $unpack, $argumentName, $argumentLine, null];
                        break;
                    }
                    $parameter = $parameters[\count($parameters) - 1];
                    if (!$parameter->isVariadic()) {
                        $newArguments[$i] = [$argumentValue, $argumentValueType, $unpack, $argumentName, $argumentLine, null];
                        break;
                        // func_get_args
                    }
                } else {
                    $parameter = $parameters[$i];
                }
            } elseif (\array_key_exists($argumentName, $parametersByName)) {
                $namedArgumentAlreadyOccurred = \true;
                $parameter = $parametersByName[$argumentName];
            } else {
                $namedArgumentAlreadyOccurred = \true;
                $parametersCount = \count($parameters);
                if (\count($unusedParametersByName) !== 0 || !$parametersAcceptor->isVariadic() || $parametersCount <= 0 || $isBuiltin) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($unknownParameterMessage, $argumentName))->line($argumentLine)->build();
                    $newArguments[$i] = [$argumentValue, $argumentValueType, $unpack, $argumentName, $argumentLine, null];
                    continue;
                }
                $parameter = $parameters[$parametersCount - 1];
            }
            if ($namedArgumentAlreadyOccurred && $argumentName === null && !$unpack) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Named argument cannot be followed by a positional argument.')->line($argumentLine)->nonIgnorable()->build();
                $newArguments[$i] = [$argumentValue, $argumentValueType, $unpack, $argumentName, $argumentLine, null];
                continue;
            }
            $newArguments[$i] = [$argumentValue, $argumentValueType, $unpack, $argumentName, $argumentLine, $parameter];
            if ($hasNamedArguments && !$parameter->isVariadic() && !\array_key_exists($parameter->getName(), $unusedParametersByName)) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Argument for parameter $%s has already been passed.', $parameter->getName()))->line($argumentLine)->build();
                continue;
            }
            unset($unusedParametersByName[$parameter->getName()]);
        }
        if ($hasNamedArguments) {
            foreach ($unusedParametersByName as $parameter) {
                if ($parameter->isOptional()) {
                    continue;
                }
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($missingParameterMessage, \sprintf('%s (%s)', $parameter->getName(), $parameter->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()))))->line($line)->build();
            }
        }
        return [$errors, $newArguments];
    }
}
