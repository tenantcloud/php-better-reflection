<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<CallToFunctionStamentWithoutSideEffectsRule>
 */
class CallToFunctionStamentWithoutSideEffectsRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions\CallToFunctionStamentWithoutSideEffectsRule($this->createReflectionProvider());
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/function-call-statement-no-side-effects.php'], [['Call to function sprintf() on a separate line has no effect.', 11]]);
    }
    public function testPhpDoc() : void
    {
        require_once __DIR__ . '/data/function-call-statement-no-side-effects-phpdoc-definition.php';
        $this->analyse([__DIR__ . '/data/function-call-statement-no-side-effects-phpdoc.php'], [['Call to function FunctionCallStatementNoSideEffectsPhpDoc\\pure1() on a separate line has no effect.', 8], ['Call to function FunctionCallStatementNoSideEffectsPhpDoc\\pure2() on a separate line has no effect.', 9], ['Call to function FunctionCallStatementNoSideEffectsPhpDoc\\pure3() on a separate line has no effect.', 10], ['Call to function FunctionCallStatementNoSideEffectsPhpDoc\\pureAndThrowsVoid() on a separate line has no effect.', 11]]);
    }
    public function testBug4455() : void
    {
        require_once __DIR__ . '/data/bug-4455.php';
        $this->analyse([__DIR__ . '/data/bug-4455.php'], []);
    }
}
