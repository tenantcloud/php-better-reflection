<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Tests;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MethodTypeSpecifyingExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
class AssertionClassMethodTypeSpecifyingExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MethodTypeSpecifyingExtension
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
    public function isMethodSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        if ($this->nullContext === null) {
            return $methodReflection->getName() === 'assertString';
        }
        if ($this->nullContext) {
            return $methodReflection->getName() === 'assertString' && $context->null();
        }
        return $methodReflection->getName() === 'assertString' && !$context->null();
    }
    public function specifyTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes(['$foo' => [$node->args[0]->value, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]]);
    }
}
