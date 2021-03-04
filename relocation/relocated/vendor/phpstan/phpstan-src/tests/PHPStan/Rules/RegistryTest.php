<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
class RegistryTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testGetRules() : void
    {
        $rule = new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\DummyRule();
        $registry = new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Registry([$rule]);
        $rules = $registry->getRules(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall::class);
        $this->assertCount(1, $rules);
        $this->assertSame($rule, $rules[0]);
        $this->assertCount(0, $registry->getRules(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall::class));
    }
    public function testGetRulesWithTwoDifferentInstances() : void
    {
        $fooRule = new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\UniversalRule(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall::class, static function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array {
            return ['Foo error'];
        });
        $barRule = new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\UniversalRule(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall::class, static function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array {
            return ['Bar error'];
        });
        $registry = new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Registry([$fooRule, $barRule]);
        $rules = $registry->getRules(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall::class);
        $this->assertCount(2, $rules);
        $this->assertSame($fooRule, $rules[0]);
        $this->assertSame($barRule, $rules[1]);
        $this->assertCount(0, $registry->getRules(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall::class));
    }
}
