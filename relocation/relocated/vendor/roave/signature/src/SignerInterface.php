<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Roave\Signature;

interface SignerInterface
{
    public function sign(string $phpCode) : string;
}
