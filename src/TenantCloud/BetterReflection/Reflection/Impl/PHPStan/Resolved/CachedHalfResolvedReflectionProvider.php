<?php

namespace TenantCloud\BetterReflection\Reflection\Impl\PHPStan\Resolved;

use ReflectionClass;
use TenantCloud\BetterReflection\Cache\Cache;
use TenantCloud\BetterReflection\Cache\ReflectionCacheKeyMaster;
use TenantCloud\BetterReflection\Provider\ReflectionProvider;

/**
 * Wraps PHPStan based reflection with some caching magic.
 *
 * This is under PHPStan\ namespace because it's known which methods of the delegated PHPStan reflection
 * are executed quick and which aren't, so we're not generalizing all reflection sources.
 */
class CachedHalfResolvedReflectionProvider implements ReflectionProvider
{
	public function __construct(
		private ReflectionCacheKeyMaster $reflectionCacheKeyMaster,
		private Cache $cache,
		private HalfResolvedFactory $halfResolvedFactory,
	) {
	}

	public function provideClass(string $className): HalfResolvedClassReflection
	{
		$reflection = new ReflectionClass($className);

		return $this->cache->remember(
			$this->reflectionCacheKeyMaster->key($reflection),
			$this->reflectionCacheKeyMaster->variableKey($reflection),
			fn () => $this->halfResolvedFactory->create($className),
		);
	}
}
