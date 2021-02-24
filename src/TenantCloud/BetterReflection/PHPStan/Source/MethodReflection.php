<?php

namespace TenantCloud\BetterReflection\PHPStan\Source;

use PHPStan\Reflection\ParametersAcceptor;
use ReflectionMethod;

class MethodReflection
{
	public function __construct(
		private \PHPStan\Reflection\MethodReflection $extensionMethod,
		public ParametersAcceptor $variant,
		public ReflectionMethod $nativeMethod,
	) {
	}
}
