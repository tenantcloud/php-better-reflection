<?php

namespace TenantCloud\BetterReflection\Relocated\SpecifiedTypesClosureUse;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $call, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $bar) : void
    {
        if ($call->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier && $bar->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
            function () use($call) : void {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PhpParser\\Node\\Identifier', $call->name);
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $bar->name);
            };
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PhpParser\\Node\\Identifier', $call->name);
        }
    }
    public function doBar(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $call, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $bar) : void
    {
        if ($call->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier && $bar->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
            $a = 1;
            function () use($call, &$a) : void {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PhpParser\\Node\\Identifier', $call->name);
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $bar->name);
            };
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PhpParser\\Node\\Identifier', $call->name);
        }
    }
}
