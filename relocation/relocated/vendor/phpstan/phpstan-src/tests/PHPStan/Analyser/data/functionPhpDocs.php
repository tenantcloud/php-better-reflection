<?php

namespace TenantCloud\BetterReflection\Relocated\MethodPhpDocsNamespace;

use TenantCloud\BetterReflection\Relocated\SomeNamespace\Amet as Dolor;
use TenantCloud\BetterReflection\Relocated\SomeNamespace\Consecteur;
/**
 * @param Foo|Bar $unionTypeParameter
 * @param int $anotherMixedParameter
 * @param int $anotherMixedParameter
 * @paran int $yetAnotherMixedProperty
 * @param int $integerParameter
 * @param integer $anotherIntegerParameter
 * @param aRray $arrayParameterOne
 * @param mixed[] $arrayParameterOther
 * @param Lorem $objectRelative
 * @param \SomeOtherNamespace\Ipsum $objectFullyQualified
 * @param Dolor $objectUsed
 * @param null|int $nullableInteger
 * @param Dolor|null $nullableObject
 * @param Dolor $anotherNullableObject
 * @param Null $nullType
 * @param Bar $barObject
 * @param Foo $conflictedObject
 * @param Baz $moreSpecifiedObject
 * @param resource $resource
 * @param array[array] $yetAnotherAnotherMixedParameter
 * @param \\Test\Bar $yetAnotherAnotherAnotherMixedParameter
 * @param New $yetAnotherAnotherAnotherAnotherMixedParameter
 * @param void $voidParameter
 * @param Consecteur $useWithoutAlias
 * @param true $true
 * @param false $false
 * @param true $boolTrue
 * @param false $boolFalse
 * @param bool $trueBoolean
 * @param bool $parameterWithDefaultValueFalse
 * @return Foo
 */
function doFoo($mixedParameter, $unionTypeParameter, $anotherMixedParameter, $yetAnotherMixedParameter, $integerParameter, $anotherIntegerParameter, $arrayParameterOne, $arrayParameterOther, $objectRelative, $objectFullyQualified, $objectUsed, $nullableInteger, $nullableObject, $nullType, $barObject, \TenantCloud\BetterReflection\Relocated\MethodPhpDocsNamespace\Bar $conflictedObject, \TenantCloud\BetterReflection\Relocated\MethodPhpDocsNamespace\Bar $moreSpecifiedObject, $resource, $yetAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherAnotherMixedParameter, $voidParameter, $useWithoutAlias, $true, $false, bool $boolTrue, bool $boolFalse, bool $trueBoolean, $parameterWithDefaultValueFalse = \false, $anotherNullableObject = null)
{
    $fooFunctionResult = doFoo();
    $barFunctionResult = doBar();
    foreach ($moreSpecifiedObject->doFluentUnionIterable() as $fluentUnionIterableBaz) {
        die;
    }
}
function doBar() : \TenantCloud\BetterReflection\Relocated\MethodPhpDocsNamespace\Bar
{
}
