<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeStringResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class SignatureMapParser
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeStringResolver $typeStringResolver;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeStringResolver $typeNodeResolver)
    {
        $this->typeStringResolver = $typeNodeResolver;
    }
    /**
     * @param mixed[] $map
     * @param string|null $className
     * @return \PHPStan\Reflection\SignatureMap\FunctionSignature
     */
    public function getFunctionSignature(array $map, ?string $className) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\FunctionSignature
    {
        $parameterSignatures = $this->getParameters(\array_slice($map, 1));
        $hasVariadic = \false;
        foreach ($parameterSignatures as $parameterSignature) {
            if ($parameterSignature->isVariadic()) {
                $hasVariadic = \true;
                break;
            }
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\FunctionSignature($parameterSignatures, $this->getTypeFromString($map[0], $className), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $hasVariadic);
    }
    private function getTypeFromString(string $typeString, ?string $className) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($typeString === '') {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true);
        }
        return $this->typeStringResolver->resolve($typeString, new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope(null, [], $className));
    }
    /**
     * @param array<string, string> $parameterMap
     * @return array<int, \PHPStan\Reflection\SignatureMap\ParameterSignature>
     */
    private function getParameters(array $parameterMap) : array
    {
        $parameterSignatures = [];
        foreach ($parameterMap as $parameterName => $typeString) {
            [$name, $isOptional, $passedByReference, $isVariadic] = $this->getParameterInfoFromName($parameterName);
            $parameterSignatures[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\ParameterSignature($name, $isOptional, $this->getTypeFromString($typeString, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $passedByReference, $isVariadic);
        }
        return $parameterSignatures;
    }
    /**
     * @param string $parameterNameString
     * @return mixed[]
     */
    private function getParameterInfoFromName(string $parameterNameString) : array
    {
        $matches = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::match($parameterNameString, '#^(?P<reference>&(?:\\.\\.\\.)?r?w?_?)?(?P<variadic>\\.\\.\\.)?(?P<name>[^=]+)?(?P<optional>=)?($)#');
        if ($matches === null || !isset($matches['optional'])) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $isVariadic = $matches['variadic'] !== '';
        $reference = $matches['reference'];
        if (\strpos($reference, '&...') === 0) {
            $reference = '&' . \substr($reference, 4);
            $isVariadic = \true;
        }
        if (\strpos($reference, '&rw') === 0) {
            $passedByReference = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createReadsArgument();
        } elseif (\strpos($reference, '&w') === 0) {
            $passedByReference = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createCreatesNewVariable();
        } else {
            $passedByReference = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo();
        }
        $isOptional = $isVariadic || $matches['optional'] !== '';
        $name = $matches['name'] !== '' ? $matches['name'] : '...';
        return [$name, $isOptional, $passedByReference, $isVariadic];
    }
}
