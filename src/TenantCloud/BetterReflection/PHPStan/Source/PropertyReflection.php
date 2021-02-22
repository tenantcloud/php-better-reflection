<?php

namespace TenantCloud\BetterReflection\PHPStan\Source;

use PHPStan\Reflection\Php\PhpPropertyReflection;
use PHPStan\Type\Type;
use ReflectionProperty;

class PropertyReflection
{
	public function __construct(
		private PhpPropertyReflection $extensionProperty,
		public ReflectionProperty $nativeProperty,
	) {
	}

	public function type(): Type
	{
		return $this->extensionProperty->getReadableType();
	}
}
