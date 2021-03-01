<?php

namespace TenantCloud\BetterReflection\PHPStan\Resolved;

use Ds\Sequence;
use Ds\Vector;
use PHPStan\Type\Generic\TemplateTypeHelper;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Type;
use ReflectionAttribute;
use ReflectionMethod;
use TenantCloud\BetterReflection\Reflection\AttributeSequence;
use TenantCloud\BetterReflection\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Shared\DelegatedAttributeSequence;

class HalfResolvedMethodReflection implements MethodReflection
{
	/**
	 * @param HalfResolvedTypeParameterReflection[]     $typeParameters
	 * @param HalfResolvedFunctionParameterReflection[] $parameters
	 */
	public function __construct(
		private string $className,
		private string $name,
		private array $typeParameters,
		private array $parameters,
		private Type $returnType,
	) {
	}

	public static function __set_state(array $data): static
	{
		return new self(
			className: $data['className'],
			name: $data['name'],
			typeParameters: $data['typeParameters'],
			parameters: $data['parameters'],
			returnType: $data['returnType'],
		);
	}

	public function name(): string
	{
		return $this->name;
	}

	public function typeParameters(): Sequence
	{
		return new Vector($this->typeParameters);
	}

	public function parameters(): Sequence
	{
		return new Vector($this->parameters);
	}

	public function returnType(): Type
	{
		return $this->returnType;
	}

	public function attributes(): AttributeSequence
	{
		return (new DelegatedAttributeSequence(new Vector($this->nativeReflection()->getAttributes())))
			->map(function (ReflectionAttribute $nativeAttribute) {
				// Why, PHP? Why the hell wouldn't you JUST give a list of instantiated attributes like other languages? ...
				return $nativeAttribute->newInstance();
			});
	}

	public function invoke(object $receiver, mixed ...$args): mixed
	{
		return $this->nativeReflection()->invoke($receiver, ...$args);
	}

	public function withTemplateTypeMap(TemplateTypeMap $map): self
	{
		return new self(
			className: $this->className,
			name: $this->name,
			typeParameters: $this->typeParameters,
			parameters: array_map(fn (HalfResolvedFunctionParameterReflection $reflection) => $reflection->withTemplateTypeMap($map), $this->parameters),
			returnType: TemplateTypeHelper::resolveTemplateTypes(
				$this->returnType,
				$map
			)
		);
	}

	private function nativeReflection(): ReflectionMethod
	{
		$method = new ReflectionMethod($this->className, $this->name);
		$method->setAccessible(true);

		return $method;
	}
}
