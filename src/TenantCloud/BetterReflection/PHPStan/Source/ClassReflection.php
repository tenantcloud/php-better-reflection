<?php

namespace TenantCloud\BetterReflection\PHPStan\Source;

use PHPStan\Reflection\Php\PhpClassReflectionExtension;
use ReflectionProperty;

class ClassReflection
{
	public function __construct(
		private \PHPStan\Reflection\ClassReflection $delegate,
		private PhpClassReflectionExtension $phpClassReflectionExtension,
	) {
	}

	/**
	 * @return PropertyReflection[]
	 */
	public function properties(): array
	{
		$nativeProperties = $this->delegate
			->getNativeReflection()
			->getProperties();

		return array_map(function (ReflectionProperty $nativeProperty) {
			$extensionProperty = $this->phpClassReflectionExtension->getNativeProperty($this->delegate, $nativeProperty->getName());

			return new PropertyReflection(
				$extensionProperty,
				$nativeProperty,
			);
		}, $nativeProperties);
	}
}
