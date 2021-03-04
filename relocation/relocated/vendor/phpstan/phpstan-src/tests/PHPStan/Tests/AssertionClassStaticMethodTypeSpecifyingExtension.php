<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Tests;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticMethodTypeSpecifyingExtension;
class AssertionClassStaticMethodTypeSpecifyingExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticMethodTypeSpecifyingExtension
{
    /** @var bool|null */
    private $nullContext;
    public function __construct(?bool $nullContext)
    {
        $this->nullContext = $nullContext;
    }
    public function getClass() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClass::class;
    }
    public function isStaticMethodSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $staticMethodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        if ($this->nullContext === null) {
            return $staticMethodReflection->getName() === 'assertInt';
        }
        if ($this->nullContext) {
            return $staticMethodReflection->getName() === 'assertInt' && $context->null();
        }
        return $staticMethodReflection->getName() === 'assertInt' && !$context->null();
    }
    public function specifyTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $staticMethodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes(['$bar' => [$node->args[0]->value, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType()]]);
    }
}
