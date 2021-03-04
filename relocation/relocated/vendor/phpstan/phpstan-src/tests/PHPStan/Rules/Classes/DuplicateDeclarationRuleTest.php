<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<\PHPStan\Rules\Classes\DuplicateDeclarationRule>
 */
class DuplicateDeclarationRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\DuplicateDeclarationRule();
    }
    public function testDuplicateDeclarations() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('This test needs static reflection');
        }
        $this->analyse([__DIR__ . '/data/duplicate-declarations.php'], [['Cannot redeclare constant DuplicateDeclarations\\Foo::CONST1.', 8], ['Cannot redeclare constant DuplicateDeclarations\\Foo::CONST2.', 10], ['Cannot redeclare property DuplicateDeclarations\\Foo::$prop1.', 17], ['Cannot redeclare property DuplicateDeclarations\\Foo::$prop2.', 20], ['Cannot redeclare method DuplicateDeclarations\\Foo::func1().', 27], ['Cannot redeclare method DuplicateDeclarations\\Foo::Func1().', 35]]);
    }
    public function testDuplicatePromotedProperty() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('This test needs static reflection');
        }
        $this->analyse([__DIR__ . '/data/duplicate-promoted-property.php'], [['Cannot redeclare property DuplicatedPromotedProperty\\Foo::$foo.', 11], ['Cannot redeclare property DuplicatedPromotedProperty\\Foo::$bar.', 13]]);
    }
}
