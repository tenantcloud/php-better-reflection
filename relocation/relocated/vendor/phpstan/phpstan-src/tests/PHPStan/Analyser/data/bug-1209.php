<?php

namespace TenantCloud\BetterReflection\Relocated\Bug1209;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class HelloWorld
{
    /**
     * @param mixed[]|string $value
     */
    public function sayHello($value) : void
    {
        $isArray = \is_array($value);
        if ($isArray) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', $value);
        }
    }
    /**
     * @param mixed[]|string $value
     */
    public function sayHello2($value) : void
    {
        $isArray = \is_array($value);
        $value = 123;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('123', $value);
        if ($isArray) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('123', $value);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('123', $value);
    }
}
