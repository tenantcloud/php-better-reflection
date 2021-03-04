<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
class RuleErrorBuilderTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testMessageAndBuild() : void
    {
        $builder = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Foo');
        $ruleError = $builder->build();
        $this->assertSame('Foo', $ruleError->getMessage());
    }
    public function testMessageAndLineAndBuild() : void
    {
        $builder = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Foo')->line(25);
        $ruleError = $builder->build();
        $this->assertSame('Foo', $ruleError->getMessage());
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\LineRuleError::class, $ruleError);
        $this->assertSame(25, $ruleError->getLine());
    }
    public function testMessageAndFileAndBuild() : void
    {
        $builder = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Foo')->file('Bar.php');
        $ruleError = $builder->build();
        $this->assertSame('Foo', $ruleError->getMessage());
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FileRuleError::class, $ruleError);
        $this->assertSame('Bar.php', $ruleError->getFile());
    }
    public function testMessageAndLineAndFileAndBuild() : void
    {
        $builder = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Foo')->line(25)->file('Bar.php');
        $ruleError = $builder->build();
        $this->assertSame('Foo', $ruleError->getMessage());
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\LineRuleError::class, $ruleError);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FileRuleError::class, $ruleError);
        $this->assertSame(25, $ruleError->getLine());
        $this->assertSame('Bar.php', $ruleError->getFile());
    }
}
