<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\TooWideTypehints;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<TooWideClosureReturnTypehintRule>
 */
class TooWideClosureReturnTypehintRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\TooWideTypehints\TooWideClosureReturnTypehintRule();
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/tooWideClosureReturnType.php'], [['Anonymous function never returns null so it can be removed from the return typehint.', 20]]);
    }
}
