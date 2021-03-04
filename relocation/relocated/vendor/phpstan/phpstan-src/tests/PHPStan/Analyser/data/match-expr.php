<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\MatchExpr;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param 1|2|3|4 $i
     */
    public function doFoo(int $i) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', match ($i) {
            0 => $i,
        });
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3|4', $i);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', match ($i) {
            1 => $i,
        });
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3|4', $i);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2', match ($i) {
            1, 2 => $i,
        });
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3|4', $i);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3', match ($i) {
            1, 2, 3 => $i,
        });
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3|4', $i);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('2|3', match ($i) {
            1 => exit,
            2, 3 => $i,
        });
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3|4', $i);
    }
    /**
     * @param 1|2|3|4 $i
     */
    public function doBar(int $i) : void
    {
        match ($i) {
            0 => \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $i),
            default => \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3|4', $i),
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3|4', $i);
        match ($i) {
            1 => \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $i),
            default => \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('2|3|4', $i),
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3|4', $i);
        match ($i) {
            1, 2 => \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2', $i),
            default => \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('3|4', $i),
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3|4', $i);
        match ($i) {
            1, 2, 3 => \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3', $i),
            default => \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('4', $i),
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3|4', $i);
        match ($i) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2|3|4', $i), 1, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('2|3|4', $i) => null,
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('2|3|4', $i) => null,
            default => \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('2|3|4', $i),
        };
    }
}
