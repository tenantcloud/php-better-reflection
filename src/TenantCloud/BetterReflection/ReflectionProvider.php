<?php

namespace TenantCloud\BetterReflection;

use TenantCloud\BetterReflection\Reflection\ClassReflection;

interface ReflectionProvider
{
	/**
	 * @template T
	 *
	 * @param class-string<T>|T $classNameOrObject
	 *
	 * @return ClassReflection<T>
	 */
	public function provideClass(mixed $classNameOrObject): ClassReflection;
}
