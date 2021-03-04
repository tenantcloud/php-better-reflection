<?php

namespace TenantCloud\BetterReflection\PHPStan\Resolved;

use Ds\Sequence;
use Ds\Vector;
use ReflectionAttribute;
use ReflectionClass;
use TenantCloud\BetterReflection\Reflection\AttributeSequence;
use TenantCloud\BetterReflection\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Shared\DelegatedAttributeSequence;

class HalfResolvedClassReflection implements ClassReflection
{
	/**
	 * @param HalfResolvedPropertyReflection[]      $properties
	 * @param HalfResolvedMethodReflection[]        $methods
	 * @param HalfResolvedTypeParameterReflection[] $typeParameters
	 */
	public function __construct(
		private string $className,
		private array $properties,
		private array $methods,
		private array $typeParameters,
	) {
	}

	public static function __set_state(array $data): static
	{
		return new self(
			className: $data['className'],
			properties: $data['properties'],
			methods: $data['methods'],
			typeParameters: $data['typeParameters']
		);
	}

	public function fileName(): string
	{
		return $this->nativeReflection()->getFileName();
	}

	public function typeParameters(): Sequence
	{
		return new Vector($this->typeParameters);
	}

	public function properties(): Sequence
	{
		return new Vector($this->properties);
	}

	public function methods(): Sequence
	{
		return new Vector($this->methods);
	}

	public function attributes(): AttributeSequence
	{
		return (new DelegatedAttributeSequence(new Vector($this->nativeReflection()->getAttributes())))
			->map(function (ReflectionAttribute $nativeAttribute) {
				// Why, PHP? Why the hell wouldn't you JUST give a list of instantiated attributes like other languages? ...
				return $nativeAttribute->newInstance();
			});
	}

	public function qualifiedName(): string
	{
		return $this->className;
	}

	/**
	 * @return $this
	 */
	public function withTypes(array $types): self
	{
		$map = [];
		$i = 0;

		foreach ($this->typeParameters as $tag) {
			$map[$tag->name()] = $types[$i] ?? new ErrorType();
			$i++;
		}

		return $this->withTemplateTypeMap(new TemplateTypeMap($map));
	}

	public function withTemplateTypeMap(TemplateTypeMap $map): self
	{
		return new self(
			className: $this->className,
			properties: array_map(fn (HalfResolvedPropertyReflection $reflection) => $reflection->withTemplateTypeMap($map), $this->properties),
			methods: array_map(fn (HalfResolvedMethodReflection $reflection)      => $reflection->withTemplateTypeMap($map), $this->methods),
			typeParameters: $this->typeParameters,
		);
	}

	private function nativeReflection(): ReflectionClass
	{
		return new ReflectionClass($this->className);
	}
}
