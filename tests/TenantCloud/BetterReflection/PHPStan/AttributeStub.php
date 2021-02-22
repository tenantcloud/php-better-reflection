<?php

namespace Tests\TenantCloud\BetterReflection\PHPStan;

use Attribute;

#[Attribute]
class AttributeStub
{
	public function __construct(public string $something)
	{
	}
}
