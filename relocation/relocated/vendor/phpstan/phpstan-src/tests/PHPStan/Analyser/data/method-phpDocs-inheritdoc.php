<?php

namespace TenantCloud\BetterReflection\Relocated\MethodPhpDocsNamespace;

use TenantCloud\BetterReflection\Relocated\SomeNamespace\Amet as Dolor;
use TenantCloud\BetterReflection\Relocated\SomeNamespace\Consecteur;
class FooInheritDocChild extends \TenantCloud\BetterReflection\Relocated\MethodPhpDocsNamespace\Foo
{
    /**
     * {@inheritdoc}
     */
    public function doFoo($mixedParameter, $unionTypeParameter, $anotherMixedParameter, $yetAnotherMixedParameter, $integerParameter, $anotherIntegerParameter, $arrayParameterOne, $arrayParameterOther, $objectRelative, $objectFullyQualified, $objectUsed, $nullableInteger, $nullableObject, $selfType, $staticType, $nullType, $barObject, \TenantCloud\BetterReflection\Relocated\MethodPhpDocsNamespace\Bar $conflictedObject, \TenantCloud\BetterReflection\Relocated\MethodPhpDocsNamespace\Bar $moreSpecifiedObject, $resource, $yetAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherAnotherMixedParameter, $voidParameter, $useWithoutAlias, $true, $false, bool $boolTrue, bool $boolFalse, bool $trueBoolean, $objectWithoutNativeTypehint, object $objectWithNativeTypehint, $parameterWithDefaultValueFalse = \false, $anotherNullableObject = null)
    {
        $parent = new \TenantCloud\BetterReflection\Relocated\MethodPhpDocsNamespace\FooParent();
        $differentInstance = new \TenantCloud\BetterReflection\Relocated\MethodPhpDocsNamespace\Foo();
        /** @var self $inlineSelf */
        $inlineSelf = doFoo();
        /** @var Bar $inlineBar */
        $inlineBar = doFoo();
        foreach ($moreSpecifiedObject->doFluentUnionIterable() as $fluentUnionIterableBaz) {
            die;
        }
    }
    /**
     * {@inheritdoc}
     */
    private function privateMethodWithPhpDoc()
    {
    }
}
