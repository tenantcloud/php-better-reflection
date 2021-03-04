<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocConstructors;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param string[] $data
     */
    public function __construct($data)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>', $data);
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\InheritDocConstructors\Foo
{
    public function __construct($name, $data)
    {
        parent::__construct($data);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $name);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>', $data);
    }
}
