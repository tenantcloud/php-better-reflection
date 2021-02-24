<?php

namespace TenantCloud\BetterReflection\PHPStan\Resolved;

use PHPStan\Type\Type;
use ReflectionAttribute;
use ReflectionMethod;
use TenantCloud\BetterReflection\Reflection\FunctionParameterReflection;
use TenantCloud\BetterReflection\Reflection\MethodReflection;

class HalfResolvedMethodReflection implements MethodReflection
{
	/**
	 * @param FunctionParameterReflection[] $parameters
	 */
	public function __construct(
		private string $className,
		private string $name,
		private array $parameters,
		private Type $returnType,
	) {
	}

	public static function __set_state(array $data): static
	{
		return new self(
			className: $data['className'],
			name: $data['name'],
			parameters: $data['parameters'],
			returnType: $data['returnType'],
		);
	}

	public function name(): string
	{
		return $this->name;
	}

	public function parameters(): array
	{
		return $this->parameters;
	}

	public function returnType(): Type
	{
		return $this->returnType;
	}

	public function attributes(): array
	{
		$nativeAttributes = $this->nativeReflection()->getAttributes();

		return array_map(function (ReflectionAttribute $nativeAttribute) {
			// Why, PHP? Why the hell wouldn't you JUST give a list of instantiated attributes like other languages? ...
			return $nativeAttribute->newInstance();
		}, $nativeAttributes);
	}

	public function invoke(object $receiver, mixed ...$args): mixed
	{
		return $this->nativeReflection()->invoke($receiver, $args);
	}

	private function nativeReflection(): ReflectionMethod
	{
		return new ReflectionMethod($this->className, $this->name);
	}
}
