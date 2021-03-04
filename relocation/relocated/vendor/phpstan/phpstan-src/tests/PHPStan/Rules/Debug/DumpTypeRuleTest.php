<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Debug;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<DumpTypeRule>
 */
class DumpTypeRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Debug\DumpTypeRule($this->createReflectionProvider());
    }
    public function testRuleInPhpStanNamespace() : void
    {
        $this->analyse([__DIR__ . '/data/dump-type.php'], [['Dumped type: array&nonEmpty', 10], ['Missing argument for PHPStan\\dumpType() function call.', 11]]);
    }
    public function testRuleInDifferentNamespace() : void
    {
        $this->analyse([__DIR__ . '/data/dump-type-ns.php'], [['Dumped type: array&nonEmpty', 10]]);
    }
    public function testRuleInUse() : void
    {
        $this->analyse([__DIR__ . '/data/dump-type-use.php'], [['Dumped type: array&nonEmpty', 12], ['Dumped type: array&nonEmpty', 13]]);
    }
}
