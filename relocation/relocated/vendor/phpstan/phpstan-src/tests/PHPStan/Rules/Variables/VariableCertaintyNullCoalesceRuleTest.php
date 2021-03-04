<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Variables;

/**
 * @extends \PHPStan\Testing\RuleTestCase<VariableCertaintyNullCoalesceRule>
 */
class VariableCertaintyNullCoalesceRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Variables\VariableCertaintyNullCoalesceRule();
    }
    public function testVariableCertaintyInNullCoalesce() : void
    {
        $this->analyse([__DIR__ . '/data/variable-certainty-null.php'], [['Variable $scalar on left side of ?? always exists and is not nullable.', 6], ['Variable $doesNotExist on left side of ?? is never defined.', 8], ['Variable $a on left side of ?? is always null.', 13]]);
    }
    public function testVariableCertaintyInNullCoalesceAssign() : void
    {
        if (!self::$useStaticReflectionProvider && \PHP_VERSION_ID < 70400) {
            $this->markTestSkipped('Test requires PHP 7.4.');
        }
        $this->analyse([__DIR__ . '/data/variable-certainty-null-assign.php'], [['Variable $scalar on left side of ??= always exists and is not nullable.', 6], ['Variable $doesNotExist on left side of ??= is never defined.', 8], ['Variable $a on left side of ??= is always null.', 13]]);
    }
    public function testNullCoalesceInGlobalScope() : void
    {
        $this->analyse([__DIR__ . '/data/null-coalesce-global-scope.php'], [['Variable $bar on left side of ?? always exists and is not nullable.', 6]]);
    }
}
