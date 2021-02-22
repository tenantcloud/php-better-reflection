<?php

namespace TenantCloud\BetterReflection;

use TenantCloud\BetterReflection\Reflection\ClassReflection;

interface ReflectionProvider
{
	/**
	 * @template T
	 *
	 * @param class-string<T> $className
	 *
	 * @return ClassReflection<T>
	 */
	public function provideClass(string $className): ClassReflection;
}
