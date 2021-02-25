<?php

namespace TenantCloud\BetterReflection\PHPStan\Resolved;

use Ds\Sequence;
use Ds\Vector;
use PHPStan\Type\Type;
use ReflectionAttribute;
use ReflectionParameter;
use TenantCloud\BetterReflection\Reflection\AttributeSequence;
use TenantCloud\BetterReflection\Reflection\FunctionParameterReflection;
use TenantCloud\BetterReflection\Shared\DelegatedAttributeSequence;

class HalfResolvedFunctionParameterReflection implements FunctionParameterReflection
{
	public function __construct(
		private string $className,
		private string $functionName,
		private string $name,
		private Type $type,
	) {
	}

	public static function __set_state(array $data): static
	{
		return new self(
			className: $data['className'],
			functionName: $data['functionName'],
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
		return (new DelegatedAttributeSequence(new Vector($this->nativeReflection()->getAttributes())))
			->map(function (ReflectionAttribute $nativeAttribute) {
				// Why, PHP? Why the hell wouldn't you JUST give a list of instantiated attributes like other languages? ...
				return $nativeAttribute->newInstance();
			});
	}

	private function nativeReflection(): ReflectionParameter
	{
		return new ReflectionParameter([$this->className, $this->functionName], $this->name);
	}
}
