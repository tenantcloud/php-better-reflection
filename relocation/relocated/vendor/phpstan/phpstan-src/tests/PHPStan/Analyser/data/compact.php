<?php

namespace TenantCloud\BetterReflection\Relocated\CompactExtension;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(?\'bar\' => mixed)', \compact(['foo' => 'bar']));
function (string $dolor) : void {
    $foo = 'bar';
    $bar = 'baz';
    if (\rand(0, 1)) {
        $lorem = 'ipsum';
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'foo\' => \'bar\', \'bar\' => \'baz\')', \compact('foo', ['bar']));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'foo\' => \'bar\', \'bar\' => \'baz\', ?\'lorem\' => \'ipsum\')', \compact([['foo']], 'bar', 'lorem'));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, mixed>', \compact($dolor));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, mixed>', \compact([$dolor]));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array()', \compact([]));
};
