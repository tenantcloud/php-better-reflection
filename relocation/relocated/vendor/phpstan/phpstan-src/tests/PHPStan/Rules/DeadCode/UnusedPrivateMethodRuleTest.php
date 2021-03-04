<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\DeadCode;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<UnusedPrivateMethodRule>
 */
class UnusedPrivateMethodRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\DeadCode\UnusedPrivateMethodRule();
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/unused-private-method.php'], [['Method UnusedPrivateMethod\\Foo::doFoo() is unused.', 8], ['Method UnusedPrivateMethod\\Foo::doBar() is unused.', 13], ['Static method UnusedPrivateMethod\\Foo::unusedStaticMethod() is unused.', 44], ['Method UnusedPrivateMethod\\Bar::doBaz() is unused.', 59], ['Method UnusedPrivateMethod\\Lorem::doBaz() is unused.', 97]]);
    }
    public function testBug3630() : void
    {
        $this->analyse([__DIR__ . '/data/bug-3630.php'], []);
    }
    public function testNullsafe() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0.');
        }
        $this->analyse([__DIR__ . '/data/nullsafe-unused-private-method.php'], []);
    }
}
