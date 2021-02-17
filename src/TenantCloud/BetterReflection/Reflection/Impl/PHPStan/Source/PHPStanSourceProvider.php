<?php

namespace TenantCloud\BetterReflection\Reflection\Impl\PHPStan\Source;

use PHPStan\Reflection\Php\PhpClassReflectionExtension;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider;

class PHPStanSourceProvider
{
	public function __construct(
		private ReflectionProvider $phpStanProvider,
		private PhpClassReflectionExtension $phpClassReflectionExtension,
	) {
	}

	public function provideClass(string $className): ClassReflection
	{
		return new ClassReflection(
			$this->phpStanProvider->getClass($className),
			$this->phpClassReflectionExtension,
		);
	}
}
