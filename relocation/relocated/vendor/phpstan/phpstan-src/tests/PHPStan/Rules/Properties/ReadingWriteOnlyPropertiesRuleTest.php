<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<ReadingWriteOnlyPropertiesRule>
 */
class ReadingWriteOnlyPropertiesRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    /** @var bool */
    private $checkThisOnly;
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\ReadingWriteOnlyPropertiesRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyDescriptor(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, $this->checkThisOnly, \true, \false), $this->checkThisOnly);
    }
    public function testPropertyMustBeReadableInAssignOp() : void
    {
        $this->checkThisOnly = \false;
        $this->analyse([__DIR__ . '/data/writing-to-read-only-properties.php'], [['Property WritingToReadOnlyProperties\\Foo::$writeOnlyProperty is not readable.', 22], ['Property WritingToReadOnlyProperties\\Foo::$writeOnlyProperty is not readable.', 32]]);
    }
    public function testPropertyMustBeReadableInAssignOpCheckThisOnly() : void
    {
        $this->checkThisOnly = \true;
        $this->analyse([__DIR__ . '/data/writing-to-read-only-properties.php'], [['Property WritingToReadOnlyProperties\\Foo::$writeOnlyProperty is not readable.', 22]]);
    }
    public function testReadingWriteOnlyProperties() : void
    {
        $this->checkThisOnly = \false;
        $this->analyse([__DIR__ . '/data/reading-write-only-properties.php'], [['Property ReadingWriteOnlyProperties\\Foo::$writeOnlyProperty is not readable.', 17], ['Property ReadingWriteOnlyProperties\\Foo::$writeOnlyProperty is not readable.', 22]]);
    }
    public function testReadingWriteOnlyPropertiesCheckThisOnly() : void
    {
        $this->checkThisOnly = \true;
        $this->analyse([__DIR__ . '/data/reading-write-only-properties.php'], [['Property ReadingWriteOnlyProperties\\Foo::$writeOnlyProperty is not readable.', 17]]);
    }
    public function testNullsafe() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0.');
        }
        $this->checkThisOnly = \false;
        $this->analyse([__DIR__ . '/data/reading-write-only-properties-nullsafe.php'], [['Property ReadingWriteOnlyProperties\\Foo::$writeOnlyProperty is not readable.', 9]]);
    }
}
