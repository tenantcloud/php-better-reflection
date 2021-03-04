<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Constants;

/**
 * @extends \PHPStan\Testing\RuleTestCase<ConstantRule>
 */
class ConstantRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Constants\ConstantRule();
    }
    public function testConstants() : void
    {
        \define('FOO_CONSTANT', 'foo');
        \define('TenantCloud\\BetterReflection\\Relocated\\Constants\\BAR_CONSTANT', 'bar');
        \define('TenantCloud\\BetterReflection\\Relocated\\OtherConstants\\BAZ_CONSTANT', 'baz');
        $this->analyse([__DIR__ . '/data/constants.php'], [['Constant NONEXISTENT_CONSTANT not found.', 10, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['Constant DEFINED_CONSTANT not found.', 13, 'Learn more at https://phpstan.org/user-guide/discovering-symbols']]);
    }
    public function testCompilerHaltOffsetConstantFalseDetection() : void
    {
        $this->analyse([__DIR__ . '/data/compiler-halt-offset-const-defined.php'], []);
    }
    public function testCompilerHaltOffsetConstantIsUndefinedDetection() : void
    {
        $this->analyse([__DIR__ . '/data/compiler-halt-offset-const-not-defined.php'], [['Constant __COMPILER_HALT_OFFSET__ not found.', 3, 'Learn more at https://phpstan.org/user-guide/discovering-symbols']]);
    }
    public function testConstEquals() : void
    {
        $this->analyse([__DIR__ . '/data/const-equals.php'], []);
    }
    public function testConstEqualsNoNamespace() : void
    {
        $this->analyse([__DIR__ . '/data/const-equals-no-namespace.php'], []);
    }
}
