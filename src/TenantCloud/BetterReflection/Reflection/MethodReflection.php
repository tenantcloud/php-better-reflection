<?php

namespace TenantCloud\BetterReflection\Reflection;

use Ds\Sequence;
use PHPStan\Type\Type;

/**
 * @template T of object Type that this method belongs to
 * @template R Type of it's return value
 */
interface MethodReflection
{
	public function name(): string;

	/**
	 * @return Sequence<FunctionParameterReflection>
	 */
	public function parameters(): Sequence;

	public function returnType(): Type;

	/**
	 * @return Sequence<object>
	 */
	public function attributes(): Sequence;

	/**
	 * @param T $receiver
	 *
	 * @return R
	 */
	public function invoke(object $receiver, mixed ...$args): mixed;
}
