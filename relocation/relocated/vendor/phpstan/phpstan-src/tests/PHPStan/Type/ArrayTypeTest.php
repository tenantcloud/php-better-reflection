<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
class ArrayTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType()), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([], []), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\false, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticTypeFactory::falsey())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([], []), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([], []), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param ArrayType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataAccepts() : array
    {
        $reflectionProvider = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([], []), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0)], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1)], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()])), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1)], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1)], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType($reflectionProvider->getClass(self::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('dataAccepts')]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1)], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType($reflectionProvider->getClass(self::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('dataIsSuperTypeOf')])]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataAccepts
     * @param ArrayType $acceptingType
     * @param Type $acceptedType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType $acceptingType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $acceptedType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $acceptingType->accepts($acceptedType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $acceptingType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $acceptedType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataDescribe() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType()), 'array<int>']];
    }
    /**
     * @dataProvider dataDescribe
     * @param ArrayType $type
     * @param string $expectedDescription
     */
    public function testDescribe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType $type, string $expectedDescription) : void
    {
        $this->assertSame($expectedDescription, $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
    }
    public function dataInferTemplateTypes() : array
    {
        $templateType = static function (string $name) : Type {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), $name, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        };
        return ['valid templated item' => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $templateType('T')), ['T' => 'DateTime']], 'receive mixed' => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $templateType('T')), []], 'receive non-accepted' => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $templateType('T')), []], 'receive union items' => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType()])), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $templateType('T')), ['T' => 'int|string']], 'receive union' => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType())]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $templateType('T')), ['T' => 'int|string']]];
    }
    /**
     * @dataProvider dataInferTemplateTypes
     * @param array<string,string> $expectedTypes
     */
    public function testResolveTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $received, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $template, array $expectedTypes) : void
    {
        $result = $template->inferTemplateTypes($received);
        $this->assertSame($expectedTypes, \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : string {
            return $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise());
        }, $result->getTypes()));
    }
}
