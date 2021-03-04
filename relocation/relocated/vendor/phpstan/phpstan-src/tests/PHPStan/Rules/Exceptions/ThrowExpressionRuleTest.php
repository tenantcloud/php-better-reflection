<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Exceptions;

use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<ThrowExpressionRule>
 */
class ThrowExpressionRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    /** @var PhpVersion */
    private $phpVersion;
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Exceptions\ThrowExpressionRule($this->phpVersion);
    }
    public function dataRule() : array
    {
        return [[70400, [['Throw expression is supported only on PHP 8.0 and later.', 10]]], [80000, []]];
    }
    /**
     * @dataProvider dataRule
     * @param int $phpVersion
     * @param mixed[] $expectedErrors
     */
    public function testRule(int $phpVersion, array $expectedErrors) : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0');
        }
        $this->phpVersion = new \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion($phpVersion);
        $this->analyse([__DIR__ . '/data/throw-expr.php'], $expectedErrors);
    }
}
