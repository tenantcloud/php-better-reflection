<?php

namespace TenantCloud\BetterReflection\Reflection;

/**
 * @template T Class being reflected
 */
interface ClassReflection extends QualifiableElement
{
	public function fileName(): string;

	/**
	 * @return PropertyReflection<T, mixed>[]
	 */
	public function properties(): array;

	/**
	 * @return object[]
	 */
	public function attributes(): array;
}
