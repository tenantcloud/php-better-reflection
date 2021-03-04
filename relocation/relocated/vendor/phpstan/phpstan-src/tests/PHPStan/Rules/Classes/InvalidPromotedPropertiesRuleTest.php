<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<InvalidPromotedPropertiesRule>
 */
class InvalidPromotedPropertiesRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    /** @var int */
    private $phpVersion;
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\InvalidPromotedPropertiesRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion($this->phpVersion));
    }
    public function testNotSupportedOnPhp7() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires static reflection.');
        }
        $this->phpVersion = 70400;
        $this->analyse([__DIR__ . '/data/invalid-promoted-properties.php'], [['Promoted properties are supported only on PHP 8.0 and later.', 8], ['Promoted properties are supported only on PHP 8.0 and later.', 10], ['Promoted properties are supported only on PHP 8.0 and later.', 17], ['Promoted properties are supported only on PHP 8.0 and later.', 21], ['Promoted properties are supported only on PHP 8.0 and later.', 23], ['Promoted properties are supported only on PHP 8.0 and later.', 31], ['Promoted properties are supported only on PHP 8.0 and later.', 38], ['Promoted properties are supported only on PHP 8.0 and later.', 45]]);
    }
    public function testSupportedOnPhp8() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires static reflection.');
        }
        $this->phpVersion = 80000;
        $this->analyse([__DIR__ . '/data/invalid-promoted-properties.php'], [['Promoted properties can be in constructor only.', 10], ['Promoted properties can be in constructor only.', 17], ['Promoted properties can be in constructor only.', 21], ['Promoted properties can be in constructor only.', 23], ['Promoted properties are not allowed in abstract constructors.', 31], ['Promoted properties are not allowed in abstract constructors.', 38], ['Promoted property parameter $i can not be variadic.', 45]]);
    }
}
