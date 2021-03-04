<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Cast;

use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<UnsetCastRule>
 */
class UnsetCastRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    /** @var int */
    private $phpVersion;
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Cast\UnsetCastRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion($this->phpVersion));
    }
    public function dataRule() : array
    {
        return [[70400, []], [80000, [['The (unset) cast is no longer supported in PHP 8.0 and later.', 6]]]];
    }
    /**
     * @dataProvider dataRule
     * @param int $phpVersion
     * @param mixed[] $errors
     */
    public function testRule(int $phpVersion, array $errors) : void
    {
        $this->phpVersion = $phpVersion;
        $this->analyse([__DIR__ . '/data/unset-cast.php'], $errors);
    }
}
