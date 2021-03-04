<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\DeadCode;

use TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<NoopRule>
 */
class NoopRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\DeadCode\NoopRule(new \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard());
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/noop.php'], [['Expression "$arr" on a separate line does not do anything.', 9], ['Expression "$arr[\'test\']" on a separate line does not do anything.', 10], ['Expression "$foo::$test" on a separate line does not do anything.', 11], ['Expression "$foo->test" on a separate line does not do anything.', 12], ['Expression "\'foo\'" on a separate line does not do anything.', 14], ['Expression "1" on a separate line does not do anything.', 15], ['Expression "@\'foo\'" on a separate line does not do anything.', 17], ['Expression "+1" on a separate line does not do anything.', 18], ['Expression "-1" on a separate line does not do anything.', 19], ['Expression "isset($test)" on a separate line does not do anything.', 25], ['Expression "empty($test)" on a separate line does not do anything.', 26], ['Expression "true" on a separate line does not do anything.', 27], ['Expression "\\DeadCodeNoop\\Foo::TEST" on a separate line does not do anything.', 28], ['Expression "(string) 1" on a separate line does not do anything.', 30]]);
    }
    public function testNullsafe() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0.');
        }
        $this->analyse([__DIR__ . '/data/nullsafe-property-fetch-noop.php'], [['Expression "$ref?->name" on a separate line does not do anything.', 10]]);
    }
}
