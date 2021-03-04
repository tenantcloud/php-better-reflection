<?php

namespace TenantCloud\BetterReflection\PHPStan\Source;

use ReflectionMethod;
use ReflectionProperty;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpClassReflectionExtension;

class ClassReflection
{
	public function __construct(
		public \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $delegate,
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
