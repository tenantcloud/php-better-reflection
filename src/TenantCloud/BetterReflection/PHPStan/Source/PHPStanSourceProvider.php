<?php

namespace TenantCloud\BetterReflection\PHPStan\Source;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;

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
