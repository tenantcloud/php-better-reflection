<?php

namespace TenantCloud\BetterReflection\Reflection;

use PHPStan\Type\Type;

interface FunctionParameterReflection
{
	public function name(): string;

	public function type(): Type;

	/**
	 * @return object[]
	 */
	public function attributes(): array;
}
