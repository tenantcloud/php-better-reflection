<?php

namespace Tests\TenantCloud\BetterReflection\PHPStan;

use ComplexGenericsExample\SomeClass;
use TenantCloud\BetterReflection\Delegation\PHPStan\DefaultReflectionProviderFactory;

#[AttributeStub(something: '123')]
class ClassStub
{
	/** @var DefaultReflectionProviderFactory[] */
	private array $factories;

	/** @var DefaultReflectionProviderFactory<SomeClass> */
	private DefaultReflectionProviderFactory $generic;
}
