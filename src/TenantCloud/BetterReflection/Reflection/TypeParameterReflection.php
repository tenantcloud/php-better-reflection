<?php

namespace TenantCloud\BetterReflection\Reflection;

use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\Type;

interface TypeParameterReflection
{
	public function name(): string;

	public function upperBound(): Type;

	public function variance(): TemplateTypeVariance;
}
