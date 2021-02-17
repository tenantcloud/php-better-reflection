<?php

namespace TenantCloud\Standard\Lazy;

/**
 * Represents a value with lazy initialization.
 *
 * @template T
 */
interface Lazy
{
	/**
	 * Gets the lazily initialized value of the current Lazy instance. Once the value
	 * was initialized it must not change during the rest of lifetime of this Lazy instance.
	 *
	 * @return T
	 */
	public function value(): mixed;

	/**
	 * Whether a value for this Lazy instance has been already initialized.
	 */
	public function isInitialized(): bool;
}
