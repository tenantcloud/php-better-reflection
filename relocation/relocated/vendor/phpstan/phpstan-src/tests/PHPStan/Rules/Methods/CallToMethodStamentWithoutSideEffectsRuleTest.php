<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<CallToMethodStamentWithoutSideEffectsRule>
 */
class CallToMethodStamentWithoutSideEffectsRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\CallToMethodStamentWithoutSideEffectsRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, \false, \true, \false));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/method-call-statement-no-side-effects.php'], [['Call to method DateTimeImmutable::modify() on a separate line has no effect.', 15], ['Call to static method DateTimeImmutable::createFromFormat() on a separate line has no effect.', 16], ['Call to method Exception::getCode() on a separate line has no effect.', 21], ['Call to method MethodCallStatementNoSideEffects\\Bar::doPure() on a separate line has no effect.', 63], ['Call to method MethodCallStatementNoSideEffects\\Bar::doPureWithThrowsVoid() on a separate line has no effect.', 64]]);
    }
    public function testNullsafe() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0.');
        }
        $this->analyse([__DIR__ . '/data/nullsafe-method-call-statement-no-side-effects.php'], [['Call to method Exception::getMessage() on a separate line has no effect.', 10]]);
    }
    public function testBug4232() : void
    {
        $this->analyse([__DIR__ . '/data/bug-4232.php'], []);
    }
    public function testPhpDoc() : void
    {
        $this->analyse([__DIR__ . '/data/method-call-statement-no-side-effects-phpdoc.php'], [['Call to method MethodCallStatementNoSideEffects\\Bzz::pure1() on a separate line has no effect.', 39], ['Call to method MethodCallStatementNoSideEffects\\Bzz::pure2() on a separate line has no effect.', 40], ['Call to method MethodCallStatementNoSideEffects\\Bzz::pure3() on a separate line has no effect.', 41]]);
    }
    public function testBug4455() : void
    {
        $this->analyse([__DIR__ . '/data/bug-4455.php'], []);
    }
}
