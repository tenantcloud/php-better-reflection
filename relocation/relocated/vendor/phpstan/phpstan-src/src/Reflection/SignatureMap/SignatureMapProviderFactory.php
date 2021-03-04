<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap;

use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
class SignatureMapProviderFactory
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\FunctionSignatureMapProvider $functionSignatureMapProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\Php8SignatureMapProvider $php8SignatureMapProvider;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\FunctionSignatureMapProvider $functionSignatureMapProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\Php8SignatureMapProvider $php8SignatureMapProvider)
    {
        $this->phpVersion = $phpVersion;
        $this->functionSignatureMapProvider = $functionSignatureMapProvider;
        $this->php8SignatureMapProvider = $php8SignatureMapProvider;
    }
    public function create() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\SignatureMapProvider
    {
        if ($this->phpVersion->getVersionId() < 80000) {
            return $this->functionSignatureMapProvider;
        }
        return $this->php8SignatureMapProvider;
    }
}
