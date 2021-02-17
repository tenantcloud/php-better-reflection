<?php

namespace TenantCloud\BetterReflection\Reflection;

use PHPStan\Type\Type;

/**
 * @template T of object Type that this property belongs to
 * @template R Type of it's value
 */
interface PropertyReflection
{
	public function name(): string;

	public function type(): Type;

	/**
	 * @return object[]
	 */
	public function attributes(): array;

	/**
	 * @param T $receiver
	 *
	 * @return R
	 */
	public function get(object $receiver);

	/**
	 * @param T $receiver
	 * @param R $value
	 */
	public function set(object $receiver, mixed $value): void;
}
