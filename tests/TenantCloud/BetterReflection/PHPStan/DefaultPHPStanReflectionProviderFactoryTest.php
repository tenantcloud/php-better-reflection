<?php

namespace Tests\TenantCloud\BetterReflection\PHPStan;

use Ds\Pair;
use Ds\Vector;
use PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Delegation\PHPStan\DefaultReflectionProviderFactory;
use TenantCloud\BetterReflection\PHPStan\DefaultPHPStanReflectionProviderFactory;
use TenantCloud\BetterReflection\PHPStan\Resolved\HalfResolvedFunctionParameterReflection;
use TenantCloud\BetterReflection\PHPStan\Resolved\HalfResolvedMethodReflection;
use TenantCloud\BetterReflection\PHPStan\Resolved\HalfResolvedPropertyReflection;
use TenantCloud\BetterReflection\PHPStan\Resolved\HalfResolvedTypeParameterReflection;
use TenantCloud\BetterReflection\Relocated\ComplexGenericsExample\SomeClass;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariant;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GenericParametersAcceptorResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\DummyParameter;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeParameterStrategy;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Shared\DelegatedAttributeSequence;

class DefaultPHPStanReflectionProviderFactoryTest extends TestCase
{
	private DefaultPHPStanReflectionProviderFactory $factory;

	protected function setUp(): void
	{
		parent::setUp();

		$this->factory = new DefaultPHPStanReflectionProviderFactory(__DIR__ . '/../../../../tmp');
	}

	public function testInferrenceWorksWithoutProvidingClass(): void
	{
		$templateTypeScope = TemplateTypeScope::createWithClass(ClassStub::class);

		$variant = GenericParametersAcceptorResolver::resolve([
			new IntegerType(),
			new NullType(),
		], new FunctionVariant(
			templateTypeMap: new TemplateTypeMap([
				'T' => new MixedType(),
			]),
			resolvedTemplateTypeMap: TemplateTypeMap::createEmpty(),
			parameters: [
				new DummyParameter(
					name: 'value',
					type: new TemplateMixedType(
						$templateTypeScope,
						new TemplateTypeParameterStrategy(),
						TemplateTypeVariance::createInvariant(),
						'T',
					),
					optional: false,
					passedByReference: PassedByReference::createNo(),
					variadic: false,
					defaultValue: null,
				),
				new DummyParameter(
					name: 'adapter',
					type: new GenericObjectType(SomeClass::class, [
						new TemplateMixedType(
							$templateTypeScope,
							new TemplateTypeParameterStrategy(),
							TemplateTypeVariance::createInvariant(),
							'T',
						),
					]),
					optional: false,
					passedByReference: PassedByReference::createNo(),
					variadic: false,
					defaultValue: null,
				),
			],
			isVariadic: false,
			returnType: new ArrayType(
				new MixedType(),
				new TemplateMixedType(
					$templateTypeScope,
					new TemplateTypeParameterStrategy(),
					TemplateTypeVariance::createInvariant(),
					'T',
				)
			),
		));

		self::assertEquals(
			new ArrayType(
				new MixedType(),
				new IntegerType(),
			),
			$variant->getReturnType()
		);
		self::assertEquals(
			new GenericObjectType(SomeClass::class, [
				new IntegerType(),
			]),
			$variant->getParameters()[1]->getType(),
		);
	}

	public function testClassStub(): void
	{
		$reflection = $this->factory
			->create()
			->provideClass(new GenericObjectType(
				ClassStub::class,
				[
					new StringType(),
					new IntegerType(),
				]
			));

		self::assertSame(ClassStub::class, $reflection->qualifiedName());

		$typeParameters = $reflection->typeParameters();
		self::assertCount(2, $typeParameters);
		self::assertEquals(new Vector([
			new HalfResolvedTypeParameterReflection(
				'T',
				new MixedType(),
				TemplateTypeVariance::createInvariant(),
			),
			new HalfResolvedTypeParameterReflection(
				'S',
				new IntegerType(),
				TemplateTypeVariance::createCovariant(),
			),
		]), $typeParameters);

		$attributes = $reflection->attributes();
		self::assertCount(1, $attributes);
		self::assertEquals(new DelegatedAttributeSequence(new Vector([
			new AttributeStub('123'),
		])), $attributes);

		$properties = $reflection->properties();
		self::assertCount(2, $properties);
		self::assertEquals(new Vector([
			new HalfResolvedPropertyReflection(
				ClassStub::class,
				'factories',
				new ArrayType(
					new MixedType(),
					new ObjectType(DefaultReflectionProviderFactory::class)
				)
			),
			new HalfResolvedPropertyReflection(
				ClassStub::class,
				'generic',
				new GenericObjectType(
					DefaultReflectionProviderFactory::class,
					[new ObjectType(SomeStub::class), new StringType()],
				)
			),
		]), $properties);

		$methods = $reflection->methods();
		self::assertCount(1, $methods);
		self::assertEquals(new Vector([
			new HalfResolvedMethodReflection(
				ClassStub::class,
				'method',
				[
					new HalfResolvedTypeParameterReflection(
						'G',
						new TemplateMixedType(
							TemplateTypeScope::createWithMethod(ClassStub::class, 'method'),
							new TemplateTypeParameterStrategy(),
							TemplateTypeVariance::createInvariant(),
							'G',
						),
						TemplateTypeVariance::createInvariant(),
					),
				],
				[
					new HalfResolvedFunctionParameterReflection(
						ClassStub::class,
						'method',
						'param',
						new GenericObjectType(
							DefaultReflectionProviderFactory::class,
							[new ObjectType(SomeStub::class), new StringType()],
						)
					),
				],
				new GenericObjectType(
					Pair::class,
					[
						new IntegerType(),
						new TemplateMixedType(
							TemplateTypeScope::createWithMethod(ClassStub::class, 'method'),
							new TemplateTypeParameterStrategy(),
							TemplateTypeVariance::createInvariant(),
							'G',
						),
					],
				)
			),
		]), $methods);
	}
}
