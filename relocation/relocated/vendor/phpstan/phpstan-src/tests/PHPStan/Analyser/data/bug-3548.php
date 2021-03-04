<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3548;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class HelloWorld
{
    /**
     * @param int[] $arr
     */
    public function shift(array $arr) : int
    {
        if (\count($arr) === 0) {
            throw new \Exception("oops");
        }
        $name = \array_shift($arr);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $name);
        return $name;
    }
}
