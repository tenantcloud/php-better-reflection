<?php

namespace TenantCloud\BetterReflection\Relocated\Analyser\Bug2822;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
$getter = function (string $key) use($store) : int {
    return $store[$key];
};
function (array $tokens) {
    $i = 0;
    \assert($tokens[$i] === 1);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $tokens[$i]);
    $i++;
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $tokens[$i]);
};
function () use($getter) {
    $key = 'foo';
    if ($getter($key) > 4) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<5, max>', $getter($key));
        $key = 'bar';
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $getter($key));
    }
};
function (array $tokens) {
    $lastContent = 'a';
    if ($tokens[$lastContent]['code'] === 1 || $tokens[$lastContent]['code'] === 2) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2', $tokens[$lastContent]['code']);
        $lastContent = 'b';
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $tokens[$lastContent]['code']);
        if ($tokens[$lastContent]['code'] === 3) {
            echo "what?";
        }
    }
};
