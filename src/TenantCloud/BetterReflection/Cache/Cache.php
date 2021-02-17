<?php

namespace TenantCloud\BetterReflection\Cache;

use Closure;
use PHPStan\Cache\CacheStorage;

class Cache
{
	public function __construct(
		private CacheStorage $storage,
	) {
	}

	/**
	 * @template T
	 *
	 * @param Closure(): T $getValue
	 *
	 * @return T
	 */
	public function remember(string $key, string $variableKey, Closure $getValue): mixed
	{
		if ($loaded = $this->storage->load($key, $variableKey)) {
			return $loaded;
		}

		$value = $getValue();

		$this->storage->save($key, $variableKey, $value);

		return $value;
	}
}
