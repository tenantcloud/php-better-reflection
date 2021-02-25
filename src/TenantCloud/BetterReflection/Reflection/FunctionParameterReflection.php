<?php

namespace TenantCloud\BetterReflection\Reflection;

use Ds\Sequence;
use PHPStan\Type\Type;

interface FunctionParameterReflection
{
	public function name(): string;

	public function type(): Type;

	/**
	 * @return Sequence<object>
	 */
	public function attributes(): Sequence;
}
