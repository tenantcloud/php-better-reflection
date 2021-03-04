<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods;

use TenantCloud\BetterReflection\Relocated\Bug3406\AbstractFoo;
use TenantCloud\BetterReflection\Relocated\Bug3406\ClassFoo;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<AbstractMethodInNonAbstractClassRule>
 */
class AbstractMethodInNonAbstractClassRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\AbstractMethodInNonAbstractClassRule();
    }
    public function testRule() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires static reflection.');
        }
        $this->analyse([__DIR__ . '/data/abstract-method.php'], [['Non-abstract class AbstractMethod\\Bar contains abstract method doBar().', 15], ['Non-abstract class AbstractMethod\\Baz contains abstract method doBar().', 22]]);
    }
    public function testTraitProblem() : void
    {
        $this->analyse([__DIR__ . '/data/trait-method-problem.php'], []);
    }
    public function testBug3406() : void
    {
        $this->analyse([__DIR__ . '/data/bug-3406.php'], []);
    }
    public function testBug3406ReflectionCheck() : void
    {
        $this->createBroker();
        $reflectionProvider = $this->createReflectionProvider();
        $reflection = $reflectionProvider->getClass(\TenantCloud\BetterReflection\Relocated\Bug3406\ClassFoo::class);
        $this->assertSame(\TenantCloud\BetterReflection\Relocated\Bug3406\AbstractFoo::class, $reflection->getNativeMethod('myFoo')->getDeclaringClass()->getName());
        $this->assertSame(\TenantCloud\BetterReflection\Relocated\Bug3406\ClassFoo::class, $reflection->getNativeMethod('myBar')->getDeclaringClass()->getName());
    }
    public function testbug3406AnotherCase() : void
    {
        $this->analyse([__DIR__ . '/data/bug-3406_2.php'], []);
    }
    public function testBug4214() : void
    {
        $this->analyse([__DIR__ . '/data/bug-4214.php'], []);
    }
}
