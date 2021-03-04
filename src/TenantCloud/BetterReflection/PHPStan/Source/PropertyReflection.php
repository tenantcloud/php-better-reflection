<?php

namespace TenantCloud\BetterReflection\PHPStan\Source;

use ReflectionProperty;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpPropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;

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
