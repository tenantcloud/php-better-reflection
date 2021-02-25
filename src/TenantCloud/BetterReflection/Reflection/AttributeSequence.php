<?php


namespace TenantCloud\BetterReflection\Reflection;


use Ds\Sequence;

/**
 * @extends Sequence<object>
 */
interface AttributeSequence extends Sequence
{
	public function has(string $className): bool;
}
