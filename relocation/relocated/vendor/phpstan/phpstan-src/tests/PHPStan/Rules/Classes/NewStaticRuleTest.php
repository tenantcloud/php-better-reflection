<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
/**
 * @extends \PHPStan\Testing\RuleTestCase<NewStaticRule>
 */
class NewStaticRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\NewStaticRule();
    }
    public function testRule() : void
    {
        $error = 'Unsafe usage of new static().';
        $tipText = 'See: https://phpstan.org/blog/solving-phpstan-error-unsafe-usage-of-new-static';
        $this->analyse([__DIR__ . '/data/new-static.php'], [[$error, 10, $tipText], [$error, 25, $tipText]]);
    }
}
