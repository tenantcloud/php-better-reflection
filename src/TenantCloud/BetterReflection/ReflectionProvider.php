<?php

namespace TenantCloud\BetterReflection;

use TenantCloud\BetterReflection\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName;

interface ReflectionProvider
{
	/**
	 * @template T
	 *
	 * @param class-string<T>|TypeWithClassName|T $typeOrObject
	 *
	 * @return ClassReflection<T>
	 */
	public function provideClass(string | object $typeOrObject): ClassReflection;
}
