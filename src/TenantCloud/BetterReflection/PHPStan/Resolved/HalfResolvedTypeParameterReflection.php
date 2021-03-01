<?php

namespace TenantCloud\BetterReflection\PHPStan\Resolved;

use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\Type;
use TenantCloud\BetterReflection\Reflection\TypeParameterReflection;

class HalfResolvedTypeParameterReflection implements TypeParameterReflection
{
	public function __construct(
		private string $name,
		private Type $upperBound,
		private TemplateTypeVariance $variance,
	) {
	}

	public static function __set_state(array $data): static
	{
		return new self(
			name: $data['name'],
			upperBound: $data['upperBound'],
			variance: $data['variance'],
		);
	}

	public function name(): string
	{
		return $this->name;
	}

	public function upperBound(): Type
	{
		return $this->upperBound;
	}

	public function variance(): TemplateTypeVariance
	{
		return $this->variance;
	}
}
