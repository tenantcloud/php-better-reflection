<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Generics;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class TemplateTypeFactoryTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    /** @return array<array{?Type, Type}> */
    public function dataCreate() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()], [null, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()], [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), 'U', null, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType()])]];
    }
    /**
     * @dataProvider dataCreate
     */
    public function testCreate(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $bound, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $expectedBound) : void
    {
        $scope = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a');
        $templateType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create($scope, 'T', $bound, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType::class, $templateType);
        $this->assertTrue($expectedBound->equals($templateType->getBound()), \sprintf('%s -> equals(%s)', $expectedBound->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $templateType->getBound()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
}
