<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
class EvaluationOrderTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\EvaluationOrderRule();
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/evaluation-order.php'], [['six', 4], ['one', 5], ['five', 6], ['two', 7], ['three', 8], ['four', 9]]);
    }
}
