<?php

namespace TenantCloud\BetterReflection\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;

interface FunctionParameterReflection
{
	public function name(): string;

	public function type(): Type;

	public function attributes(): AttributeSequence;
}
