<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
class TemplateTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataAccepts() : array
    {
        $templateType = static function (string $name, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $bound, ?string $functionName = null) : Type {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction($functionName ?? '_'), $name, $bound, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        };
        return [[$templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [$templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTimeInterface')), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [$templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')), $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [$templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime'), 'a'), $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime'), 'b'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [$templateType('T', null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [$templateType('T', null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), $templateType('T', null)]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataAccepts
     */
    public function testAccepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedAccept, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedAcceptArg) : void
    {
        \assert($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType);
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedAccept->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
        $type = $type->toArgument();
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedAcceptArg->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s) (Argument strategy)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSuperTypeOf() : array
    {
        $templateType = static function (string $name, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $bound, ?string $functionName = null) : Type {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction($functionName ?? '_'), $name, $bound, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        };
        return [0 => [
            $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime'),
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(),
            // (T of DateTime) isSuperTypeTo DateTime
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(),
        ], 1 => [$templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')), $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 2 => [$templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime'), 'a'), $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime'), 'b'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], 3 => [
            $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(),
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(),
            // (T of DateTime) isSuperTypeTo string
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(),
        ], 4 => [
            $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTimeInterface'),
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(),
            // (T of DateTime) isSuperTypeTo DateTimeInterface
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(),
        ], 5 => [
            $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')),
            $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTimeInterface')),
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(),
            // (T of DateTime) isSuperTypeTo (T of DateTimeInterface)
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(),
        ], 6 => [
            $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(),
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(),
            // (T of DateTime) isSuperTypeTo null
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(),
        ], 7 => [
            $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')]),
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(),
            // (T of DateTime) isSuperTypeTo (DateTime|null)
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(),
        ], 8 => [
            $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTimeInterface')),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')]),
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(),
            // (T of DateTimeInterface) isSuperTypeTo (DateTime|null)
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(),
        ], 9 => [
            $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTimeInterface')]),
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(),
            // (T of DateTime) isSuperTypeTo (DateTimeInterface|null)
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(),
        ], 10 => [
            $templateType('T', null),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true),
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(),
            // T isSuperTypeTo mixed
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(),
        ], 11 => [
            $templateType('T', null),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTimeInterface::class),
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(),
            // T isSuperTypeTo DateTimeInterface
            \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(),
        ], 12 => [$templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 13 => [$templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTimeInterface::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], 14 => [$templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Throwable::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     */
    public function testIsSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedIsSuperType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedIsSuperTypeInverse) : void
    {
        \assert($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType);
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedIsSuperType->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
        $actualResult = $otherType->isSuperTypeOf($type);
        $this->assertSame($expectedIsSuperTypeInverse->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    /** @return array<string,array{Type,Type,array<string,string>}> */
    public function dataInferTemplateTypes() : array
    {
        $templateType = static function (string $name, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $bound = null, ?string $functionName = null) : Type {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction($functionName ?? '_'), $name, $bound, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        };
        return ['simple' => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), $templateType('T'), ['T' => 'int']], 'object' => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTime::class), $templateType('T'), ['T' => 'DateTime']], 'object with bound' => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTime::class), $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTimeInterface::class)), ['T' => 'DateTime']], 'wrong object with bound' => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class), $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTimeInterface::class)), []], 'template type' => [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::toArgument($templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTimeInterface::class))), $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTimeInterface::class)), ['T' => 'T of DateTimeInterface (function _(), argument)']], 'foreign template type' => [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::toArgument($templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTimeInterface::class), 'a')), $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTimeInterface::class), 'b'), ['T' => 'T of DateTimeInterface (function a(), argument)']], 'foreign template type, imcompatible bound' => [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::toArgument($templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class), 'a')), $templateType('T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTime::class), 'b'), []]];
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
