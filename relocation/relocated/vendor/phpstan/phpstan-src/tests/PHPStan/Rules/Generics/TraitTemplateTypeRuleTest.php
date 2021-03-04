<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<TraitTemplateTypeRule>
 */
class TraitTemplateTypeRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\TraitTemplateTypeRule(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\TemplateTypeCheck($broker, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($broker), ['TypeAlias' => 'int'], \true));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/trait-template.php'], [['PHPDoc tag @template for trait TraitTemplateType\\Foo cannot have existing class stdClass as its name.', 8], ['PHPDoc tag @template T for trait TraitTemplateType\\Bar has invalid bound type TraitTemplateType\\Zazzzu.', 16], ['PHPDoc tag @template T for trait TraitTemplateType\\Baz with bound type int is not supported.', 24], ['PHPDoc tag @template for trait TraitTemplateType\\Lorem cannot have existing type alias TypeAlias as its name.', 32]]);
    }
}
