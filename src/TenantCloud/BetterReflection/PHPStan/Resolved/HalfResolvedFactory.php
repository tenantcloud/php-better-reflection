<?php

namespace TenantCloud\BetterReflection\PHPStan\Resolved;

use PHPStan\Reflection\ParameterReflection;
use TenantCloud\BetterReflection\PHPStan\Source\MethodReflection;
use TenantCloud\BetterReflection\PHPStan\Source\PHPStanSourceProvider;
use TenantCloud\BetterReflection\PHPStan\Source\PropertyReflection;
use TenantCloud\Standard\Lazy\Lazy;

class HalfResolvedFactory
{
	/**
	 * @param Lazy<PHPStanSourceProvider> $sourceProvider
	 */
	public function __construct(private Lazy $sourceProvider)
	{
	}

	public function create(string $className): HalfResolvedClassReflection
	{
		$source = $this->sourceProvider->value()->provideClass($className);

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
			array_map(
				fn (MethodReflection $methodDelegate) => new HalfResolvedMethodReflection(
					$className,
					$methodDelegate->nativeMethod->getName(),
					array_map(
						fn (ParameterReflection $parameterDelegate) => new HalfResolvedFunctionParameterReflection(
							$className,
							$methodDelegate->nativeMethod->getName(),
							$parameterDelegate->getName(),
							$parameterDelegate->getType(),
						),
						$methodDelegate->variant->getParameters()
					),
					$methodDelegate->variant->getReturnType(),
				),
				$source->methods(),
			),
		);
	}
}
