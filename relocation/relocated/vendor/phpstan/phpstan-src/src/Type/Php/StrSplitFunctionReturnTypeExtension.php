<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
final class StrSplitFunctionReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var string[] */
    private array $supportedEncodings;
    public function __construct()
    {
        $supportedEncodings = [];
        if (\function_exists('mb_list_encodings')) {
            foreach (\mb_list_encodings() as $encoding) {
                $aliases = \mb_encoding_aliases($encoding);
                if ($aliases === \false) {
                    throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                }
                $supportedEncodings = \array_merge($supportedEncodings, $aliases, [$encoding]);
            }
        }
        $this->supportedEncodings = \array_map('strtoupper', $supportedEncodings);
    }
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['str_split', 'mb_str_split'], \true);
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $defaultReturnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) < 1) {
            return $defaultReturnType;
        }
        if (\count($functionCall->args) >= 2) {
            $splitLengthType = $scope->getType($functionCall->args[1]->value);
            if ($splitLengthType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                $splitLength = $splitLengthType->getValue();
                if ($splitLength < 1) {
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
                }
            }
        } else {
            $splitLength = 1;
        }
        if ($functionReflection->getName() === 'mb_str_split') {
            if (\count($functionCall->args) >= 3) {
                $strings = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($functionCall->args[2]->value));
                $values = \array_unique(\array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType $encoding) : string {
                    return $encoding->getValue();
                }, $strings));
                if (\count($values) !== 1) {
                    return $defaultReturnType;
                }
                $encoding = $values[0];
                if (!$this->isSupportedEncoding($encoding)) {
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
                }
            } else {
                $encoding = \mb_internal_encoding();
            }
        }
        if (!isset($splitLength)) {
            return $defaultReturnType;
        }
        $stringType = $scope->getType($functionCall->args[0]->value);
        if (!$stringType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType());
        }
        $stringValue = $stringType->getValue();
        $items = isset($encoding) ? \mb_str_split($stringValue, $splitLength, $encoding) : \str_split($stringValue, $splitLength);
        if (!\is_array($items)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return self::createConstantArrayFrom($items, $scope);
    }
    private function isSupportedEncoding(string $encoding) : bool
    {
        return \in_array(\strtoupper($encoding), $this->supportedEncodings, \true);
    }
    /**
     * @param string[] $constantArray
     * @param \PHPStan\Analyser\Scope $scope
     * @return \PHPStan\Type\Constant\ConstantArrayType
     */
    private static function createConstantArrayFrom(array $constantArray, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType
    {
        $keyTypes = [];
        $valueTypes = [];
        $isList = \true;
        $i = 0;
        foreach ($constantArray as $key => $value) {
            $keyType = $scope->getTypeFromValue($key);
            if (!$keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $keyTypes[] = $keyType;
            $valueTypes[] = $scope->getTypeFromValue($value);
            $isList = $isList && $key === $i;
            $i++;
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType($keyTypes, $valueTypes, $isList ? $i : 0);
    }
}
