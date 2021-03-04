<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3133;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param string[]|string $arg
     */
    public function doFoo($arg) : void
    {
        if (!\is_numeric($arg)) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>|string', $arg);
            return;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', $arg);
    }
    /**
     * @param string|bool|float|int|mixed[]|null $arg
     */
    public function doBar($arg) : void
    {
        if (\is_numeric($arg)) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float|int|(string&numeric)', $arg);
        }
    }
    /**
     * @param numeric $numeric
     * @param numeric-string $numericString
     */
    public function doBaz($numeric, string $numericString)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float|int|(string&numeric)', $numeric);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', $numericString);
    }
    /**
     * @param numeric-string $numericString
     */
    public function doLorem(string $numericString)
    {
        $a = [];
        $a[$numericString] = 'foo';
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, \'foo\'>', $a);
    }
}
