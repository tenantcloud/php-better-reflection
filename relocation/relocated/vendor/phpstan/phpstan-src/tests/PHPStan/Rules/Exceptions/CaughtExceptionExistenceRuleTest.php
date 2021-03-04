<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Exceptions;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
/**
 * @extends \PHPStan\Testing\RuleTestCase<CaughtExceptionExistenceRule>
 */
class CaughtExceptionExistenceRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Exceptions\CaughtExceptionExistenceRule($broker, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($broker), \true);
    }
    public function testCheckCaughtException() : void
    {
        $this->analyse([__DIR__ . '/data/catch.php'], [['Caught class TestCatch\\FooCatch is not an exception.', 17], ['Caught class FooCatchException not found.', 29, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['Class TestCatch\\MyCatchException referenced with incorrect case: TestCatch\\MyCatchEXCEPTION.', 41]]);
    }
    public function testClassExists() : void
    {
        $this->analyse([__DIR__ . '/data/class-exists.php'], []);
    }
    public function testBug3690() : void
    {
        $this->analyse([__DIR__ . '/data/bug-3690.php'], []);
    }
}
