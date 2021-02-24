<?php

namespace Tests\TenantCloud\BetterReflection\PHPStan;

use ComplexGenericsExample\SomeClass;
use TenantCloud\BetterReflection\Delegation\PHPStan\DefaultReflectionProviderFactory;

#[AttributeStub(something: '123')]
class ClassStub
{
	/** @var DefaultReflectionProviderFactory[] */
	#[AttributeStub('4')]
	private array $factories;

	/** @var DefaultReflectionProviderFactory<SomeClass> */
	private DefaultReflectionProviderFactory $generic;

	/**
	 * @param DefaultReflectionProviderFactory<SomeClass> $param
	 */
	#[AttributeStub('5')]
	public function method(
		#[AttributeStub('6')] DefaultReflectionProviderFactory $param
	): int {
	}
}
