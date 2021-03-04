<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<OffsetAccessAssignOpRule>
 */
class OffsetAccessAssignOpRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    /** @var bool */
    private $checkUnions;
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $ruleLevelHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, \false, $this->checkUnions, \false);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays\OffsetAccessAssignOpRule($ruleLevelHelper);
    }
    public function testRule() : void
    {
        $this->checkUnions = \true;
        $this->analyse([__DIR__ . '/data/offset-access-assignop.php'], [['Cannot assign offset \'foo\' to array|int.', 30]]);
    }
    public function testRuleWithoutUnions() : void
    {
        $this->checkUnions = \false;
        $this->analyse([__DIR__ . '/data/offset-access-assignop.php'], []);
    }
}
