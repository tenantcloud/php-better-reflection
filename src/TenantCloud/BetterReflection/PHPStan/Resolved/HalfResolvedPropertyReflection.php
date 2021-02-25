<?php

namespace TenantCloud\BetterReflection\PHPStan\Resolved;

use Ds\Sequence;
use Ds\Vector;
use PHPStan\Type\Type;
use ReflectionAttribute;
use ReflectionProperty;
use TenantCloud\BetterReflection\Reflection\AttributeSequence;
use TenantCloud\BetterReflection\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Shared\DelegatedAttributeSequence;

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

	public function attributes(): AttributeSequence
	{
		return(new DelegatedAttributeSequence(new Vector($this->nativeReflection()->getAttributes())))
			->map(function (ReflectionAttribute $nativeAttribute) {
				// Why, PHP? Why the hell wouldn't you JUST give a list of instantiated attributes like other languages? ...
				return $nativeAttribute->newInstance();
			});
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
		$property = new ReflectionProperty($this->className, $this->name);
		$property->setAccessible(true);

		return $property;
	}
}
