<?php

namespace TenantCloud\BetterReflection;

use PHPStan\Type\TypeWithClassName;
use TenantCloud\BetterReflection\Reflection\ClassReflection;

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
