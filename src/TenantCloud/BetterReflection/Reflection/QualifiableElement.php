<?php

namespace TenantCloud\BetterReflection\Reflection;

interface QualifiableElement
{
	/**
	 * @return class-string
	 */
	public function qualifiedName(): string;
}
