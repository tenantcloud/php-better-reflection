<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope;
class NameScopedPhpDocString
{
    private string $phpDocString;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope;
    public function __construct(string $phpDocString, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope)
    {
        $this->phpDocString = $phpDocString;
        $this->nameScope = $nameScope;
    }
    public function getPhpDocString() : string
    {
        return $this->phpDocString;
    }
    public function getNameScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope
    {
        return $this->nameScope;
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['phpDocString'], $properties['nameScope']);
    }
}
