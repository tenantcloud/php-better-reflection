<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<MethodTemplateTypeRule>
 */
class MethodTemplateTypeRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\MethodTemplateTypeRule(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\TemplateTypeCheck($broker, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($broker), ['TypeAlias' => 'int'], \true));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/method-template.php'], [['PHPDoc tag @template for method MethodTemplateType\\Foo::doFoo() cannot have existing class stdClass as its name.', 11], ['PHPDoc tag @template T for method MethodTemplateType\\Foo::doBar() has invalid bound type MethodTemplateType\\Zazzzu.', 19], ['PHPDoc tag @template T for method MethodTemplateType\\Bar::doFoo() shadows @template T of Exception for class MethodTemplateType\\Bar.', 37], ['PHPDoc tag @template T for method MethodTemplateType\\Baz::doFoo() with bound type int is not supported.', 50], ['PHPDoc tag @template for method MethodTemplateType\\Lorem::doFoo() cannot have existing type alias TypeAlias as its name.', 63]]);
    }
}
