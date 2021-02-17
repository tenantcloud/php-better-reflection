<?php

namespace TenantCloud\BetterReflection\Reflection\Impl\PHPStan\Resolved;

use TenantCloud\BetterReflection\Reflection\Impl\PHPStan\Source\PHPStanSourceProvider;
use TenantCloud\BetterReflection\Reflection\Impl\PHPStan\Source\PropertyReflection;

class HalfResolvedFactory
{
	public function __construct(private PHPStanSourceProvider $sourceProvider)
	{
	}

	public function create(string $className): HalfResolvedClassReflection
	{
		$source = $this->sourceProvider->provideClass($className);

		return new HalfResolvedClassReflection(
			$className,
			array_map(
				fn (PropertyReflection $propertyDelegate) => new HalfResolvedPropertyReflection(
					$className,
					$propertyDelegate->nativeProperty->getName(),
					$propertyDelegate->type(),
				),
				$source->properties(),
			),
		);
	}
}
