<?php

namespace TenantCloud\BetterReflection\Reflection\Impl\PHPStan\Resolved;

use PHPStan\Type\Type;
use ReflectionAttribute;
use ReflectionProperty;
use TenantCloud\BetterReflection\Reflection\PropertyReflection;

class HalfResolvedPropertyReflection implements PropertyReflection
{
	public function __construct(
		private string $className,
		private string $name,
		private Type $type,
	) {
	}

	public static function __set_state(array $data): static
	{
		return new self(
			className: $data['className'],
			name: $data['name'],
			type: $data['type'],
		);
	}

	public function name(): string
	{
		return $this->name;
	}

	public function type(): Type
	{
		return $this->type;
	}

	public function attributes(): array
	{
		$nativeAttributes = $this->nativeReflection()->getAttributes();

		return array_map(function (ReflectionAttribute $nativeAttribute) {
			// Why, PHP? Why the hell wouldn't you JUST give a list of instantiated attributes like other languages? ...
			return $nativeAttribute->newInstance();
		}, $nativeAttributes);
	}

	public function get(object $receiver)
	{
		return $this->nativeReflection()->getValue($receiver);
	}

	public function set(object $receiver, mixed $value): void
	{
		$this->nativeReflection()->setValue($receiver, $value);
	}

	private function nativeReflection(): ReflectionProperty
	{
		return new ReflectionProperty($this->className, $this->name);
	}
}
