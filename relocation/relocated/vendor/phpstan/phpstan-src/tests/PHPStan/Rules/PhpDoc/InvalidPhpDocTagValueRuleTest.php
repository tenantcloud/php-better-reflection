<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\PhpDocParser;
/**
 * @extends \PHPStan\Testing\RuleTestCase<InvalidPhpDocTagValueRule>
 */
class InvalidPhpDocTagValueRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc\InvalidPhpDocTagValueRule(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::class), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\PhpDocParser::class));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/invalid-phpdoc.php'], [
            ['PHPDoc tag @param has invalid value (): Unexpected token "\\n *", expected type at offset 13', 25],
            ['PHPDoc tag @param has invalid value ($invalid): Unexpected token "$invalid", expected type at offset 24', 25],
            ['PHPDoc tag @param has invalid value ($invalid Foo): Unexpected token "$invalid", expected type at offset 43', 25],
            ['PHPDoc tag @param has invalid value (A & B | C $paramNameA): Unexpected token "|", expected variable at offset 72', 25],
            ['PHPDoc tag @param has invalid value ((A & B $paramNameB): Unexpected token "$paramNameB", expected \')\' at offset 105', 25],
            ['PHPDoc tag @param has invalid value (~A & B $paramNameC): Unexpected token "~A", expected type at offset 127', 25],
            ['PHPDoc tag @var has invalid value (): Unexpected token "\\n *", expected type at offset 156', 25],
            ['PHPDoc tag @var has invalid value ($invalid): Unexpected token "$invalid", expected type at offset 165', 25],
            ['PHPDoc tag @var has invalid value ($invalid Foo): Unexpected token "$invalid", expected type at offset 182', 25],
            ['PHPDoc tag @return has invalid value (): Unexpected token "\\n *", expected type at offset 208', 25],
            ['PHPDoc tag @return has invalid value ([int, string]): Unexpected token "[", expected type at offset 220', 25],
            ['PHPDoc tag @return has invalid value (A & B | C): Unexpected token "|", expected TOKEN_OTHER at offset 251', 25],
            ['PHPDoc tag @var has invalid value (\\\\Foo|\\Bar $test): Unexpected token "\\\\\\\\Foo|\\\\Bar", expected type at offset 9', 29],
            /*[
            			'PHPDoc tag @var has invalid value ...',
            			59,
            		],*/
            ['PHPDoc tag @var has invalid value ((Foo|Bar): Unexpected token "*/", expected \')\' at offset 18', 62],
        ]);
    }
}
