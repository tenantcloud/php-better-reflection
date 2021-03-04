<?php

namespace TenantCloud\BetterReflection\Relocated\TypesNamespaceDeductedTypes;

use TenantCloud\BetterReflection\Relocated\TypesNamespaceFunctions;
class Foo
{
    const INTEGER_CONSTANT = 1;
    const FLOAT_CONSTANT = 1.0;
    const STRING_CONSTANT = 'foo';
    const ARRAY_CONSTANT = [];
    const BOOLEAN_CONSTANT = \true;
    const NULL_CONSTANT = null;
    public function doFoo()
    {
        $integerLiteral = 1;
        $booleanLiteral = \true;
        $anotherBooleanLiteral = \false;
        $stringLiteral = 'foo';
        $floatLiteral = 1.0;
        $floatAssignedByRef =& $floatLiteral;
        $nullLiteral = null;
        $loremObjectLiteral = new \TenantCloud\BetterReflection\Relocated\TypesNamespaceDeductedTypes\Lorem();
        $mixedObjectLiteral = new $class();
        $newStatic = new static();
        $arrayLiteral = [];
        $stringFromFunction = \TenantCloud\BetterReflection\Relocated\TypesNamespaceFunctions\stringFunction();
        $fooObjectFromFunction = \TenantCloud\BetterReflection\Relocated\TypesNamespaceFunctions\objectFunction();
        $mixedFromFunction = \TenantCloud\BetterReflection\Relocated\TypesNamespaceFunctions\unknownTypeFunction();
        $foo = new self();
        die;
    }
}
