<?php

namespace TenantCloud\BetterReflection\PHPStan\Resolved;

use Ds\Sequence;
use Ds\Vector;
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

	public function parameters(): Sequence
	{
		return new Vector($this->parameters);
	}

	public function returnType(): Type
	{
		return $this->returnType;
	}

	public function attributes(): Sequence
	{
		return (new Vector($this->nativeReflection()->getAttributes()))
			->map(function (ReflectionAttribute $nativeAttribute) {
				// Why, PHP? Why the hell wouldn't you JUST give a list of instantiated attributes like other languages? ...
				return $nativeAttribute->newInstance();
			});
	}

	public function invoke(object $receiver, mixed ...$args): mixed
	{
		return $this->nativeReflection()->invoke($receiver, $args);
	}

	private function nativeReflection(): ReflectionMethod
	{
		$method = new ReflectionMethod($this->className, $this->name);
		$method->setAccessible(true);

		return $method;
	}
}
