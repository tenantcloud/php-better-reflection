<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Cast;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<InvalidCastRule>
 */
class InvalidCastRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Cast\InvalidCastRule($broker, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($broker, \true, \false, \true, \false));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/invalid-cast.php'], [['Cannot cast stdClass to string.', 7], ['Cannot cast array() to int.', 16], ['Cannot cast \'blabla\' to int.', 21], ['Cannot cast stdClass to int.', 23], ['Cannot cast stdClass to float.', 24], ['Cannot cast Test\\Foo to string.', 41], ['Cannot cast array|float|int to string.', 48]]);
    }
}
