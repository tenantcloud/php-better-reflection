<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<IncompatibleDefaultParameterTypeRule>
 */
class IncompatibleDefaultParameterTypeRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions\IncompatibleDefaultParameterTypeRule();
    }
    public function testFunctions() : void
    {
        require_once __DIR__ . '/data/incompatible-default-parameter-type-functions.php';
        $this->analyse([__DIR__ . '/data/incompatible-default-parameter-type-functions.php'], [['Default value of the parameter #1 $string (false) of function IncompatibleDefaultParameter\\takesString() is incompatible with type string.', 15]]);
    }
    public function testBug3349() : void
    {
        require_once __DIR__ . '/data/define-bug-3349.php';
        $this->analyse([__DIR__ . '/data/bug-3349.php'], []);
    }
}
