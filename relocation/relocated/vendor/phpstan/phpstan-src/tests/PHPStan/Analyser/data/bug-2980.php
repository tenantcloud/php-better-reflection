<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Bug2980;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
interface I
{
    /** @return null|string[] */
    function v() : ?array;
}
class C
{
    public function m(\TenantCloud\BetterReflection\Relocated\Bug2980\I $impl) : void
    {
        $v = $impl->v();
        // 1. Direct test in IF statement - Correct
        if (\is_array($v)) {
            \array_shift($v);
        }
        // 2. Direct test in IF (ternary)Correct
        \print_r(\is_array($v) ? \array_shift($v) : 'xyz');
        // 3. Result of test stored into variable - PHPStan thows an eror
        $isArray = \is_array($v);
        if ($isArray) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>', $v);
            \array_shift($v);
        }
    }
}
