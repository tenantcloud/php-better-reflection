<?php

namespace TenantCloud\BetterReflection\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;

interface TypeParameterReflection
{
	public function name(): string;

	public function upperBound(): Type;

	public function variance(): TemplateTypeVariance;
}
