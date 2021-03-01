<?php

namespace TenantCloud\BetterReflection\PHPStan\Source;

use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\Php\PhpClassReflectionExtension;
use ReflectionMethod;
use ReflectionProperty;

class ClassReflection
{
	public function __construct(
		public \PHPStan\Reflection\ClassReflection $delegate,
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

	public function methods(): array
	{
		$nativeMethods = $this->delegate
			->getNativeReflection()
			->getMethods();

		return array_map(function (ReflectionMethod $nativeMethod) {
			$extensionMethod = $this->phpClassReflectionExtension->getNativeMethod($this->delegate, $nativeMethod->getName());

			return new MethodReflection(
				$extensionMethod,
				ParametersAcceptorSelector::selectSingle($extensionMethod->getVariants()),
				$nativeMethod,
			);
		}, $nativeMethods);
	}
}
