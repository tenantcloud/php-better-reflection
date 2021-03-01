<?php

namespace TenantCloud\BetterReflection\PHPStan\Resolved;

use PHPStan\PhpDoc\Tag\TemplateTag;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\Type;
use TenantCloud\BetterReflection\PHPStan\Source\ClassReflection;
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
		/** @var ClassReflection $source */
		$source = $this->sourceProvider->value()->provideClass($className);

		return new HalfResolvedClassReflection(
			className: $className,
			properties: array_map(
				fn (PropertyReflection $propertyDelegate) => new HalfResolvedPropertyReflection(
					className: $className,
					name: $propertyDelegate->nativeProperty->getName(),
					type: $propertyDelegate->type(),
				),
				$source->properties(),
			),
			methods: array_map(
				fn (MethodReflection $methodDelegate) => new HalfResolvedMethodReflection(
					className: $className,
					name: $methodDelegate->nativeMethod->getName(),
					typeParameters: array_map(
						fn (Type $type, string $name) => new HalfResolvedTypeParameterReflection(
							name: $name,
							upperBound: $type,
							variance: TemplateTypeVariance::createInvariant(),
						),
						$methodDelegate->variant->getTemplateTypeMap()->getTypes(),
						array_keys($methodDelegate->variant->getTemplateTypeMap()->getTypes())
					),
					parameters: array_map(
						fn (ParameterReflection $parameterDelegate) => new HalfResolvedFunctionParameterReflection(
							$className,
							$methodDelegate->nativeMethod->getName(),
							$parameterDelegate->getName(),
							$parameterDelegate->getType(),
						),
						$methodDelegate->variant->getParameters()
					),
					returnType: $methodDelegate->variant->getReturnType(),
				),
				$source->methods(),
			),
			typeParameters: array_map(
				fn (TemplateTag $typeParameterDelegate) => new HalfResolvedTypeParameterReflection(
					name: $typeParameterDelegate->getName(),
					upperBound: $typeParameterDelegate->getBound(),
					variance: $typeParameterDelegate->getVariance(),
				),
				$source->delegate->getTemplateTags(),
			)
		);
	}
}
