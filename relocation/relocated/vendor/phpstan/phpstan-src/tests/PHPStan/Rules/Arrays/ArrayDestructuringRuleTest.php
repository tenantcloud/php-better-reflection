<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<ArrayDestructuringRule>
 */
class ArrayDestructuringRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $ruleLevelHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, \false, \true, \false);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays\ArrayDestructuringRule($ruleLevelHelper, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays\NonexistentOffsetInArrayDimFetchCheck($ruleLevelHelper, \true));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/array-destructuring.php'], [['Cannot use array destructuring on array|null.', 11], ['Offset 0 does not exist on array().', 12], ['Cannot use array destructuring on stdClass.', 13], ['Offset 2 does not exist on array(1, 2).', 15], ['Offset \'a\' does not exist on array(\'b\' => 1).', 22]]);
    }
}
