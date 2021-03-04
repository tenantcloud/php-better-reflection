<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\TooWideTypehints;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<TooWideFunctionReturnTypehintRule>
 */
class TooWideFunctionReturnTypehintRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\TooWideTypehints\TooWideFunctionReturnTypehintRule();
    }
    public function testRule() : void
    {
        require_once __DIR__ . '/data/tooWideFunctionReturnType.php';
        $this->analyse([__DIR__ . '/data/tooWideFunctionReturnType.php'], [['Function TooWideFunctionReturnType\\bar() never returns string so it can be removed from the return typehint.', 11], ['Function TooWideFunctionReturnType\\baz() never returns null so it can be removed from the return typehint.', 15], ['Function TooWideFunctionReturnType\\ipsum() never returns null so it can be removed from the return typehint.', 27]]);
    }
}
