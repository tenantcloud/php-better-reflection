<?php

namespace TenantCloud\BetterReflection\Relocated\ArrayShapeKeysStrings;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array{
     *  'namespace/key': string
     * } $slash
     * @param array<int, array{
     *   "$ref": string
     * }> $dollar
     */
    public function doFoo(array $slash, array $dollar) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType("array('namespace/key' => string)", $slash);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, array(\'$ref\' => string)>', $dollar);
    }
}
