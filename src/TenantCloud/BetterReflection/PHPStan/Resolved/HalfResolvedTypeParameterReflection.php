<?php

namespace TenantCloud\BetterReflection\PHPStan\Resolved;

use TenantCloud\BetterReflection\Reflection\TypeParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;

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
