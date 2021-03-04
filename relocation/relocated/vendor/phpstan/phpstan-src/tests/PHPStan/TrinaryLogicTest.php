<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan;

class TrinaryLogicTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataAnd() : array
    {
        return [[\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataAnd
     * @param TrinaryLogic $expectedResult
     * @param TrinaryLogic $value
     * @param TrinaryLogic ...$operands
     */
    public function testAnd(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $value, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic ...$operands) : void
    {
        $this->assertTrue($expectedResult->equals($value->and(...$operands)));
    }
    public function dataOr() : array
    {
        return [[\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataOr
     * @param TrinaryLogic $expectedResult
     * @param TrinaryLogic $value
     * @param TrinaryLogic ...$operands
     */
    public function testOr(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $value, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic ...$operands) : void
    {
        $this->assertTrue($expectedResult->equals($value->or(...$operands)));
    }
    public function dataNegate() : array
    {
        return [[\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]];
    }
    /**
     * @dataProvider dataNegate
     * @param TrinaryLogic $expectedResult
     * @param TrinaryLogic $operand
     */
    public function testNegate(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $operand) : void
    {
        $this->assertTrue($expectedResult->equals($operand->negate()));
    }
    public function dataCompareTo() : array
    {
        $yes = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        $maybe = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        $no = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        return [[$yes, $yes, null], [$maybe, $maybe, null], [$no, $no, null], [$yes, $maybe, $yes], [$yes, $no, $yes], [$maybe, $no, $maybe]];
    }
    /**
     * @dataProvider dataCompareTo
     * @param TrinaryLogic $first
     * @param TrinaryLogic $second
     * @param TrinaryLogic|null $expected
     */
    public function testCompareTo(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $first, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $second, ?\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expected) : void
    {
        $this->assertSame($expected, $first->compareTo($second));
    }
    /**
     * @dataProvider dataCompareTo
     * @param TrinaryLogic $first
     * @param TrinaryLogic $second
     * @param TrinaryLogic|null $expected
     */
    public function testCompareToInversed(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $first, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $second, ?\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expected) : void
    {
        $this->assertSame($expected, $second->compareTo($first));
    }
}
