<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<MethodSignatureVarianceRule>
 */
class MethodSignatureVarianceRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\MethodSignatureVarianceRule(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\VarianceCheck::class));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/method-signature-variance.php'], [['Template type T is declared as covariant, but occurs in contravariant position in parameter a of method MethodSignatureVariance\\C::a().', 25], ['Template type T is declared as covariant, but occurs in invariant position in parameter b of method MethodSignatureVariance\\C::a().', 25], ['Template type T is declared as covariant, but occurs in contravariant position in parameter c of method MethodSignatureVariance\\C::a().', 25], ['Template type W is declared as covariant, but occurs in contravariant position in parameter d of method MethodSignatureVariance\\C::a().', 25], ['Variance annotation is only allowed for type parameters of classes and interfaces, but occurs in template type U in in method MethodSignatureVariance\\C::b().', 35]]);
    }
}
