<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

class TypeSpecifierContextTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataContext() : array
    {
        return [[\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTrue(), [\true, \true, \false, \false, \false]], [\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy(), [\true, \true, \false, \false, \false]], [\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalse(), [\false, \false, \true, \true, \false]], [\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalsey(), [\false, \false, \true, \true, \false]], [\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createNull(), [\false, \false, \false, \false, \true]]];
    }
    /**
     * @dataProvider dataContext
     * @param \PHPStan\Analyser\TypeSpecifierContext $context
     * @param bool[] $results
     */
    public function testContext(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context, array $results) : void
    {
        $this->assertSame($results[0], $context->true());
        $this->assertSame($results[1], $context->truthy());
        $this->assertSame($results[2], $context->false());
        $this->assertSame($results[3], $context->falsey());
        $this->assertSame($results[4], $context->null());
    }
    public function dataNegate() : array
    {
        return [[\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTrue()->negate(), [\false, \true, \true, \true, \false]], [\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy()->negate(), [\false, \false, \true, \true, \false]], [\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalse()->negate(), [\true, \true, \false, \true, \false]], [\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalsey()->negate(), [\true, \true, \false, \false, \false]]];
    }
    /**
     * @dataProvider dataNegate
     * @param \PHPStan\Analyser\TypeSpecifierContext $context
     * @param bool[] $results
     */
    public function testNegate(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context, array $results) : void
    {
        $this->assertSame($results[0], $context->true());
        $this->assertSame($results[1], $context->truthy());
        $this->assertSame($results[2], $context->false());
        $this->assertSame($results[3], $context->falsey());
        $this->assertSame($results[4], $context->null());
    }
    public function testNegateNull() : void
    {
        $this->expectException(\TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException::class);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createNull()->negate();
    }
}
