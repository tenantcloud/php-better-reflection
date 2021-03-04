<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generators;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<YieldInGeneratorRule>
 */
class YieldInGeneratorRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generators\YieldInGeneratorRule(\true);
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/yield-in-generator.php'], [['Yield can be used only with these return types: Generator, Iterator, Traversable, iterable.', 13], ['Yield can be used only with these return types: Generator, Iterator, Traversable, iterable.', 14], ['Yield can be used only with these return types: Generator, Iterator, Traversable, iterable.', 31], ['Yield can be used only with these return types: Generator, Iterator, Traversable, iterable.', 32], ['Yield can be used only with these return types: Generator, Iterator, Traversable, iterable.', 37], ['Yield can be used only with these return types: Generator, Iterator, Traversable, iterable.', 38], ['Yield can be used only with these return types: Generator, Iterator, Traversable, iterable.', 55], ['Yield can be used only with these return types: Generator, Iterator, Traversable, iterable.', 56], ['Yield can be used only with these return types: Generator, Iterator, Traversable, iterable.', 87], ['Yield can be used only with these return types: Generator, Iterator, Traversable, iterable.', 88]]);
    }
    public function testRuleOutsideFunction() : void
    {
        $this->analyse([__DIR__ . '/data/yield-outside-function.php'], [['Yield can be used only inside a function.', 5], ['Yield can be used only inside a function.', 6]]);
    }
}
