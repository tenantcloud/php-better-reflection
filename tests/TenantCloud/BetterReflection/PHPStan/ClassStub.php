<?php

namespace Tests\TenantCloud\BetterReflection\PHPStan;

use ComplexGenericsExample\SomeClass;
use Ds\Pair;
use TenantCloud\BetterReflection\Delegation\PHPStan\DefaultReflectionProviderFactory;

/**
 * @template T
 * @template-covariant S of int
 */
#[AttributeStub(something: '123')]
class ClassStub
{
	/** @var DefaultReflectionProviderFactory[] */
	#[AttributeStub('4')]
	private array $factories;

	/** @var DefaultReflectionProviderFactory<SomeClass, T> */
	private DefaultReflectionProviderFactory $generic;

	/**
	 * @template G
	 *
	 * @param DefaultReflectionProviderFactory<SomeClass, T> $param
	 *
	 * @return Pair<S, G>
	 */
	#[AttributeStub('5')]
	public function method(
		#[AttributeStub('6')] DefaultReflectionProviderFactory $param
	): Pair {
	}
}
