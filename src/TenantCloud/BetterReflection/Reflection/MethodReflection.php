<?php

namespace TenantCloud\BetterReflection\Reflection;

use PHPStan\Type\Type;

/**
 * @template T of object Type that this method belongs to
 * @template R Type of it's return value
 */
interface MethodReflection
{
	public function name(): string;

	/**
	 * @return FunctionParameterReflection[]
	 */
	public function parameters(): array;

	public function returnType(): Type;

	/**
	 * @return object[]
	 */
	public function attributes(): array;

	/**
	 * @param T $receiver
	 *
	 * @return R
	 */
	public function invoke(object $receiver, mixed ...$args): mixed;
}
