<?php

namespace TenantCloud\BetterReflection\PHPStan\Source;

use ReflectionMethod;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor;

class MethodReflection
{
	public function __construct(
		private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $extensionMethod,
		public ParametersAcceptor $variant,
		public ReflectionMethod $nativeMethod,
	) {
	}
}
