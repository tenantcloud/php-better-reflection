<?php

namespace TenantCloud\BetterReflection\Reflection;

use Ds\Sequence;

/**
 * @template T Class being reflected
 */
interface ClassReflection extends QualifiableElement
{
	public function fileName(): string;

	/**
	 * @return Sequence<PropertyReflection<T, mixed>>
	 */
	public function properties(): Sequence;

	/**
	 * @return Sequence<MethodReflection<T, mixed>>
	 */
	public function methods(): Sequence;

	public function attributes(): AttributeSequence;
}
