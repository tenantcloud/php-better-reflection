<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<CallToStaticMethodStamentWithoutSideEffectsRule>
 */
class CallToStaticMethodStamentWithoutSideEffectsRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\CallToStaticMethodStamentWithoutSideEffectsRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($broker, \true, \false, \true, \false), $broker);
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/static-method-call-statement-no-side-effects.php'], [['Call to static method DateTimeImmutable::createFromFormat() on a separate line has no effect.', 12], ['Call to static method DateTimeImmutable::createFromFormat() on a separate line has no effect.', 13], ['Call to method DateTime::format() on a separate line has no effect.', 23]]);
    }
    public function testPhpDoc() : void
    {
        $this->analyse([__DIR__ . '/data/static-method-call-statement-no-side-effects-phpdoc.php'], [['Call to static method StaticMethodCallStatementNoSideEffects\\BzzStatic::pure1() on a separate line has no effect.', 39], ['Call to static method StaticMethodCallStatementNoSideEffects\\BzzStatic::pure2() on a separate line has no effect.', 40], ['Call to static method StaticMethodCallStatementNoSideEffects\\BzzStatic::pure3() on a separate line has no effect.', 41], ['Call to static method StaticMethodCallStatementNoSideEffects\\PureThrows::pureAndThrowsVoid() on a separate line has no effect.', 67]]);
    }
    public function testBug4455() : void
    {
        $this->analyse([__DIR__ . '/data/bug-4455-static.php'], []);
    }
}
