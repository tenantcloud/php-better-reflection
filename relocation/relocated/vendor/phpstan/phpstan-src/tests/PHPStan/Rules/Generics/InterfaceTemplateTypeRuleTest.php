<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<InterfaceTemplateTypeRule>
 */
class InterfaceTemplateTypeRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\InterfaceTemplateTypeRule(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\TemplateTypeCheck($broker, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($broker), ['TypeAlias' => 'int'], \true));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/interface-template.php'], [['PHPDoc tag @template for interface InterfaceTemplateType\\Foo cannot have existing class stdClass as its name.', 8], ['PHPDoc tag @template T for interface InterfaceTemplateType\\Bar has invalid bound type InterfaceTemplateType\\Zazzzu.', 16], ['PHPDoc tag @template T for interface InterfaceTemplateType\\Baz with bound type int is not supported.', 24], ['PHPDoc tag @template for interface InterfaceTemplateType\\Lorem cannot have existing type alias TypeAlias as its name.', 32]]);
    }
}
