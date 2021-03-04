<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2835AssertTypes;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array<int, array> $tokens
     * @return bool
     */
    public function doFoo(array $tokens) : bool
    {
        $i = 0;
        while (isset($tokens[$i])) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $i);
            if ($tokens[$i]['code'] !== 1) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~1', $tokens[$i]['code']);
                $i++;
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $i);
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $tokens[$i]['code']);
                continue;
            }
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $tokens[$i]['code']);
            $i++;
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $i);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $tokens[$i]['code']);
            if ($tokens[$i]['code'] !== 2) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~2', $tokens[$i]['code']);
                $i++;
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $i);
                continue;
            }
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('2', $tokens[$i]['code']);
            return \true;
        }
        return \false;
    }
}
