<?php

namespace Tests\TenantCloud\BetterReflection\PHPStan;

use ComplexGenericsExample\SomeClass;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Delegation\PHPStan\DefaultReflectionProviderFactory;
use TenantCloud\BetterReflection\PHPStan\DefaultPHPStanReflectionProviderFactory;
use TenantCloud\BetterReflection\PHPStan\Resolved\HalfResolvedPropertyReflection;

class DefaultPHPStanReflectionProviderFactoryTest extends TestCase
{
	private DefaultPHPStanReflectionProviderFactory $factory;

	protected function setUp(): void
	{
		parent::setUp();

		$this->factory = new DefaultPHPStanReflectionProviderFactory(__DIR__ . '/../../../../tmp');
	}

	public function testClassStub(): void
	{
		$reflection = $this->factory
			->create()
			->provideClass(ClassStub::class);

		self::assertSame(ClassStub::class, $reflection->qualifiedName());

		$attributes = $reflection->attributes();
		self::assertCount(1, $attributes);
		self::assertEquals([
			new AttributeStub('123'),
		], $attributes);

		$properties = $reflection->properties();
		self::assertCount(2, $properties);
		self::assertEquals([
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
					[new ObjectType(SomeClass::class)],
				)
			),
		], $properties);
	}
}
