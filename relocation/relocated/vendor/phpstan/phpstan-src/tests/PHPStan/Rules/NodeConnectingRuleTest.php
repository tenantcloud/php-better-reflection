<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<NodeConnectingRule>
 */
class NodeConnectingRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NodeConnectingRule();
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/node-connecting.php'], [['TenantCloud\\BetterReflection\\Relocated\\Parent: PhpParser\\Node\\Stmt\\If_, previous: PhpParser\\Node\\Stmt\\Switch_, next: PhpParser\\Node\\Stmt\\Foreach_', 11]]);
    }
}
