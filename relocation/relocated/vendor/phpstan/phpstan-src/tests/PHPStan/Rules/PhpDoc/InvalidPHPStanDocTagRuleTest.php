<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\PhpDocParser;
/**
 * @extends \PHPStan\Testing\RuleTestCase<InvalidPHPStanDocTagRule>
 */
class InvalidPHPStanDocTagRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc\InvalidPHPStanDocTagRule(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::class), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\PhpDocParser::class));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/invalid-phpstan-doc.php'], [['Unknown PHPDoc tag: @phpstan-extens', 7], ['Unknown PHPDoc tag: @phpstan-pararm', 14]]);
    }
}
