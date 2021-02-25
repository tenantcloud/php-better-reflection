<?php


namespace TenantCloud\BetterReflection\Reflection;


use Ds\Sequence;

interface AttributeSequence extends Sequence
{
	public function has(string $className): bool;
}
