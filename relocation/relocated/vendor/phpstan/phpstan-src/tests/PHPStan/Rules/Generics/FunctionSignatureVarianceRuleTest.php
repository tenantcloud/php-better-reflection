<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<FunctionSignatureVarianceRule>
 */
class FunctionSignatureVarianceRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\FunctionSignatureVarianceRule(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\VarianceCheck::class));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/function-signature-variance.php'], [['Variance annotation is only allowed for type parameters of classes and interfaces, but occurs in template type T in in function FunctionSignatureVariance\\f().', 20]]);
    }
}
