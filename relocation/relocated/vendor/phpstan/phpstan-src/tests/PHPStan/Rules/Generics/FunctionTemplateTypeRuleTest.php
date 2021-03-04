<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<FunctionTemplateTypeRule>
 */
class FunctionTemplateTypeRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\FunctionTemplateTypeRule(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\TemplateTypeCheck($broker, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($broker), ['TypeAlias' => 'int'], \true));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/function-template.php'], [['PHPDoc tag @template for function FunctionTemplateType\\foo() cannot have existing class stdClass as its name.', 8], ['PHPDoc tag @template T for function FunctionTemplateType\\bar() has invalid bound type FunctionTemplateType\\Zazzzu.', 16], ['PHPDoc tag @template T for function FunctionTemplateType\\baz() with bound type int is not supported.', 24], ['PHPDoc tag @template for function FunctionTemplateType\\lorem() cannot have existing type alias TypeAlias as its name.', 32]]);
    }
    public function testBug3769() : void
    {
        require_once __DIR__ . '/data/bug-3769.php';
        $this->analyse([__DIR__ . '/data/bug-3769.php'], []);
    }
}
