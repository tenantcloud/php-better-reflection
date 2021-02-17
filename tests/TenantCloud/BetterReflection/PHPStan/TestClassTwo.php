<?php

namespace Tests\TenantCloud\BetterReflection\PHPStan;

use ComplexGenericsExample\SomeClass;
use TenantCloud\BetterReflection\Delegation\PHPStan\DefaultReflectionProviderFactory;

class TestClassTwo
{
	/** @var DefaultReflectionProviderFactory[] */
	private array $factories;

	/** @var DefaultReflectionProviderFactory<SomeClass> */
	private DefaultReflectionProviderFactory $generic;
}
