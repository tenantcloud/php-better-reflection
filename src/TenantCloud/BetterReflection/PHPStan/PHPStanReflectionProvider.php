<?php

namespace TenantCloud\BetterReflection\PHPStan;

use PHPStan\Broker\Broker;
use PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider;
use PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\TypeWithClassName;
use ReflectionClass;
use TenantCloud\BetterReflection\Cache\Cache;
use TenantCloud\BetterReflection\Cache\ReflectionCacheKeyMaster;
use TenantCloud\BetterReflection\PHPStan\Resolved\HalfResolvedClassReflection;
use TenantCloud\BetterReflection\PHPStan\Resolved\HalfResolvedFactory;
use TenantCloud\BetterReflection\PHPStan\Resolved\NoResolveReflectionProvider;
use TenantCloud\BetterReflection\ReflectionProvider;

/**
 * Provides reflection through PHPStan and partly native reflection with additional caching.
 */
class PHPStanReflectionProvider implements ReflectionProvider
{
	private static bool $isBrokerBound = false;

	public function __construct(
		private ReflectionCacheKeyMaster $reflectionCacheKeyMaster,
		private Cache $cache,
		private HalfResolvedFactory $halfResolvedFactory,
	) {
		static::bindBroker();
	}

	public static function bindBroker(): void
	{
		if (static::$isBrokerBound) {
			return;
		}

		Broker::registerInstance(
			$broker = new Broker(
				reflectionProvider: new NoResolveReflectionProvider(),
				dynamicReturnTypeExtensionRegistryProvider: $dynamicReturnTypeExtensionRegistryProvider = new DirectDynamicReturnTypeExtensionRegistryProvider([], [], []),
				operatorTypeSpecifyingExtensionRegistryProvider: $operatorTypeSpecifyingExtensionRegistryProvider = new DirectOperatorTypeSpecifyingExtensionRegistryProvider([]),
				universalObjectCratesClasses: [],
			)
		);

		$dynamicReturnTypeExtensionRegistryProvider->setBroker($broker);
		$operatorTypeSpecifyingExtensionRegistryProvider->setBroker($broker);

		static::$isBrokerBound = true;
	}

	public function provideClass(string | object $typeOrObject): HalfResolvedClassReflection
	{
		if (is_string($typeOrObject)) {
			$typeOrObject = new ObjectType($typeOrObject);
		}

		if (!$typeOrObject instanceof TypeWithClassName) {
			$typeOrObject = new ObjectType(get_class($typeOrObject));
		}

		$nativeReflection = new ReflectionClass($typeOrObject->getClassName());

		/** @var HalfResolvedClassReflection $reflection */
		$reflection = $this->cache->remember(
			$this->reflectionCacheKeyMaster->key($nativeReflection),
			$this->reflectionCacheKeyMaster->variableKey($nativeReflection),
			fn () => $this->halfResolvedFactory->create($typeOrObject->getClassName()),
		);

		// Use generic types from the type's type parameters
		if ($typeOrObject instanceof GenericObjectType) {
			$reflection = $reflection->withTypes($typeOrObject->getTypes());
		}

		return $reflection;
	}
}
