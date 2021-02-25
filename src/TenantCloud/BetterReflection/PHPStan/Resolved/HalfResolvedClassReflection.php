<?php

namespace TenantCloud\BetterReflection\PHPStan\Resolved;

use Ds\Sequence;
use Ds\Vector;
use ReflectionAttribute;
use ReflectionClass;
use TenantCloud\BetterReflection\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Reflection\PropertyReflection;

class HalfResolvedClassReflection implements ClassReflection
{
	/**
	 * @param PropertyReflection[] $properties
	 * @param MethodReflection[]   $methods
	 */
	public function __construct(
		private string $className,
		private array $properties,
		private array $methods,
	) {
	}

	public static function __set_state(array $data): static
	{
		return new self(
			className: $data['className'],
			properties: $data['properties'],
			methods: $data['methods'],
		);
	}

	public function fileName(): string
	{
		return $this->nativeReflection()->getFileName();
	}

	public function properties(): Sequence
	{
		return new Vector($this->properties);
	}

	public function methods(): Sequence
	{
		return new Vector($this->methods);
	}

	public function attributes(): Sequence
	{
		return (new Vector($this->nativeReflection()->getAttributes()))
			->map(function (ReflectionAttribute $nativeAttribute) {
				// Why, PHP? Why the hell wouldn't you JUST give a list of instantiated attributes like other languages? ...
				return $nativeAttribute->newInstance();
			});
	}

	public function qualifiedName(): string
	{
		return $this->className;
	}

	private function nativeReflection(): ReflectionClass
	{
		return new ReflectionClass($this->className);
	}
}
