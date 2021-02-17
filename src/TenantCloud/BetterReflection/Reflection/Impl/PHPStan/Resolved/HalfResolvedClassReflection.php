<?php

namespace TenantCloud\BetterReflection\Reflection\Impl\PHPStan\Resolved;

use ReflectionAttribute;
use ReflectionClass;
use TenantCloud\BetterReflection\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Reflection\PropertyReflection;

class HalfResolvedClassReflection implements ClassReflection
{
	/**
	 * @param PropertyReflection[] $properties
	 */
	public function __construct(
		private string $className,
		private array $properties,
	) {
	}

	public static function __set_state(array $data): static
	{
		return new self(
			className: $data['className'],
			properties: $data['properties'],
		);
	}

	public function fileName(): string
	{
		return $this->nativeReflection()->getFileName();
	}

	public function properties(): array
	{
		return $this->properties;
	}

	public function attributes(): array
	{
		$nativeAttributes = $this->nativeReflection()->getAttributes();

		return array_map(function (ReflectionAttribute $nativeAttribute) {
			// Why, PHP? Why the hell wouldn't you JUST give a list of instantiated attributes like other languages? ...
			return $nativeAttribute->newInstance();
		}, $nativeAttributes);
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
