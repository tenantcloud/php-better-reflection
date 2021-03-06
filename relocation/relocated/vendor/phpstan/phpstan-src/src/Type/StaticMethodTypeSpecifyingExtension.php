<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
interface StaticMethodTypeSpecifyingExtension
{
    public function getClass() : string;
    public function isStaticMethodSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $staticMethodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : bool;
    public function specifyTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $staticMethodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes;
}
