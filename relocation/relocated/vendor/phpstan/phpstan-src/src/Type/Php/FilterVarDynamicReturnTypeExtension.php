<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
class FilterVarDynamicReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType $flagsString;
    /** @var array<int, Type>|null */
    private ?array $filterTypeMap = null;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->flagsString = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('flags');
    }
    /**
     * @return array<int, Type>
     */
    private function getFilterTypeMap() : array
    {
        if ($this->filterTypeMap !== null) {
            return $this->filterTypeMap;
        }
        $booleanType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType();
        $floatType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType();
        $intType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
        $stringType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType();
        $this->filterTypeMap = [$this->getConstant('FILTER_UNSAFE_RAW') => $stringType, $this->getConstant('FILTER_SANITIZE_EMAIL') => $stringType, $this->getConstant('FILTER_SANITIZE_ENCODED') => $stringType, $this->getConstant('FILTER_SANITIZE_NUMBER_FLOAT') => $stringType, $this->getConstant('FILTER_SANITIZE_NUMBER_INT') => $stringType, $this->getConstant('FILTER_SANITIZE_SPECIAL_CHARS') => $stringType, $this->getConstant('FILTER_SANITIZE_STRING') => $stringType, $this->getConstant('FILTER_SANITIZE_URL') => $stringType, $this->getConstant('FILTER_VALIDATE_BOOLEAN') => $booleanType, $this->getConstant('FILTER_VALIDATE_EMAIL') => $stringType, $this->getConstant('FILTER_VALIDATE_FLOAT') => $floatType, $this->getConstant('FILTER_VALIDATE_INT') => $intType, $this->getConstant('FILTER_VALIDATE_IP') => $stringType, $this->getConstant('FILTER_VALIDATE_MAC') => $stringType, $this->getConstant('FILTER_VALIDATE_REGEXP') => $stringType, $this->getConstant('FILTER_VALIDATE_URL') => $stringType];
        if ($this->reflectionProvider->hasConstant(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name('FILTER_SANITIZE_MAGIC_QUOTES'), null)) {
            $this->filterTypeMap[$this->getConstant('FILTER_SANITIZE_MAGIC_QUOTES')] = $stringType;
        }
        if ($this->reflectionProvider->hasConstant(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name('FILTER_SANITIZE_ADD_SLASHES'), null)) {
            $this->filterTypeMap[$this->getConstant('FILTER_SANITIZE_ADD_SLASHES')] = $stringType;
        }
        return $this->filterTypeMap;
    }
    private function getConstant(string $constantName) : int
    {
        $constant = $this->reflectionProvider->getConstant(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name($constantName), null);
        $valueType = $constant->getValueType();
        if (!$valueType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException(\sprintf('Constant %s does not have integer type.', $constantName));
        }
        return $valueType->getValue();
    }
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \strtolower($functionReflection->getName()) === 'filter_var';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $mixedType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
        $filterArg = $functionCall->args[1] ?? null;
        if ($filterArg === null) {
            $filterValue = $this->getConstant('FILTER_DEFAULT');
        } else {
            $filterType = $scope->getType($filterArg->value);
            if (!$filterType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                return $mixedType;
            }
            $filterValue = $filterType->getValue();
        }
        $flagsArg = $functionCall->args[2] ?? null;
        $inputType = $scope->getType($functionCall->args[0]->value);
        $exactType = $this->determineExactType($inputType, $filterValue);
        if ($exactType !== null) {
            $type = $exactType;
        } else {
            $type = $this->getFilterTypeMap()[$filterValue] ?? $mixedType;
            $otherType = $this->getOtherType($flagsArg, $scope);
            if ($otherType->isSuperTypeOf($type)->no()) {
                $type = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([$type, $otherType]);
            }
        }
        if ($this->hasFlag($this->getConstant('FILTER_FORCE_ARRAY'), $flagsArg, $scope)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $type);
        }
        return $type;
    }
    private function determineExactType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $in, int $filterValue) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($filterValue === $this->getConstant('FILTER_VALIDATE_BOOLEAN') && $in instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType || $filterValue === $this->getConstant('FILTER_VALIDATE_INT') && $in instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType || $filterValue === $this->getConstant('FILTER_VALIDATE_FLOAT') && $in instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType) {
            return $in;
        }
        if ($filterValue === $this->getConstant('FILTER_VALIDATE_FLOAT') && $in instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType) {
            return $in->toFloat();
        }
        return null;
    }
    private function getOtherType(?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Arg $flagsArg, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $falseType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
        if ($flagsArg === null) {
            return $falseType;
        }
        $defaultType = $this->getDefault($flagsArg, $scope);
        if ($defaultType !== null) {
            return $defaultType;
        }
        if ($this->hasFlag($this->getConstant('FILTER_NULL_ON_FAILURE'), $flagsArg, $scope)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
        }
        return $falseType;
    }
    private function getDefault(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Arg $expression, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $exprType = $scope->getType($expression->value);
        if (!$exprType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
            return null;
        }
        $optionsType = $exprType->getOffsetValueType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('options'));
        if (!$optionsType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
            return null;
        }
        $defaultType = $optionsType->getOffsetValueType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('default'));
        if (!$defaultType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
            return $defaultType;
        }
        return null;
    }
    private function hasFlag(int $flag, ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Arg $expression, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : bool
    {
        if ($expression === null) {
            return \false;
        }
        $type = $this->getFlagsValue($scope->getType($expression->value));
        return $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType && ($type->getValue() & $flag) === $flag;
    }
    private function getFlagsValue(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $exprType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (!$exprType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
            return $exprType;
        }
        return $exprType->getOffsetValueType($this->flagsString);
    }
}
