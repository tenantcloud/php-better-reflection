<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<MissingMethodImplementationRule>
 */
class MissingMethodImplementationRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\MissingMethodImplementationRule();
    }
    public function testRule() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires static reflection.');
        }
        $this->analyse([__DIR__ . '/data/missing-method-impl.php'], [['Non-abstract class MissingMethodImpl\\Baz contains abstract method doBaz() from class MissingMethodImpl\\Baz.', 24], ['Non-abstract class MissingMethodImpl\\Baz contains abstract method doFoo() from interface MissingMethodImpl\\Foo.', 24], ['Non-abstract class class@anonymous/tests/PHPStan/Rules/Methods/data/missing-method-impl.php:41 contains abstract method doFoo() from interface MissingMethodImpl\\Foo.', 41]]);
    }
    public function testBug3469() : void
    {
        $this->analyse([__DIR__ . '/data/bug-3469.php'], []);
    }
    public function testBug3958() : void
    {
        $this->analyse([__DIR__ . '/data/bug-3958.php'], []);
    }
}
