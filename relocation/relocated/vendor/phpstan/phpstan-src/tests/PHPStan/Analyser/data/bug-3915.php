<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3915;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class HelloWorld
{
    public function sayHello() : void
    {
        $lengths = [0];
        foreach ([1] as $row) {
            $lengths[] = self::getInt();
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, int>&nonEmpty', $lengths);
    }
    public static function getInt() : int
    {
        return 5;
    }
}
