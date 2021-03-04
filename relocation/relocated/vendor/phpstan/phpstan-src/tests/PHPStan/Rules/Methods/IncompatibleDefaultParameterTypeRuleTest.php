<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<IncompatibleDefaultParameterTypeRule>
 */
class IncompatibleDefaultParameterTypeRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\IncompatibleDefaultParameterTypeRule();
    }
    public function testMethods() : void
    {
        $this->analyse([__DIR__ . '/data/incompatible-default-parameter-type-methods.php'], [['Default value of the parameter #6 $resource (false) of method IncompatibleDefaultParameter\\Foo::baz() is incompatible with type resource.', 45], ['Default value of the parameter #6 $resource (false) of method IncompatibleDefaultParameter\\Foo::bar() is incompatible with type resource.', 55]]);
    }
    public function testTraitCrash() : void
    {
        $this->analyse([__DIR__ . '/data/incompatible-default-parameter-type-trait-crash.php'], []);
    }
    public function testBug4011() : void
    {
        $this->analyse([__DIR__ . '/data/bug-4011.php'], []);
    }
}
