<?php

namespace TenantCloud\BetterReflection\PHPStan;

use ReflectionClass;
use TenantCloud\BetterReflection\Cache\Cache;
use TenantCloud\BetterReflection\Cache\ReflectionCacheKeyMaster;
use TenantCloud\BetterReflection\PHPStan\Resolved\HalfResolvedClassReflection;
use TenantCloud\BetterReflection\PHPStan\Resolved\HalfResolvedFactory;
use TenantCloud\BetterReflection\ReflectionProvider;

/**
 * Provides reflection through PHPStan and partly native reflection with additional caching.
 */
class PHPStanReflectionProvider implements ReflectionProvider
{
	public function __construct(
		private ReflectionCacheKeyMaster $reflectionCacheKeyMaster,
		private Cache $cache,
		private HalfResolvedFactory $halfResolvedFactory,
	) {
	}

	public function provideClass(mixed $classNameOrObject): HalfResolvedClassReflection
	{
		$reflection = new ReflectionClass($classNameOrObject);

		return $this->cache->remember(
			$this->reflectionCacheKeyMaster->key($reflection),
			$this->reflectionCacheKeyMaster->variableKey($reflection),
			fn () => $this->halfResolvedFactory->create($reflection->getName()),
		);
	}
}
