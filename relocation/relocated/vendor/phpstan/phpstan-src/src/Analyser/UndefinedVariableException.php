<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

class UndefinedVariableException extends \TenantCloud\BetterReflection\Relocated\PHPStan\AnalysedCodeException
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope;
    private string $variableName;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, string $variableName)
    {
        parent::__construct(\sprintf('Undefined variable: $%s', $variableName));
        $this->scope = $scope;
        $this->variableName = $variableName;
    }
    public function getScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getVariableName() : string
    {
        return $this->variableName;
    }
    public function getTip() : ?string
    {
        return null;
    }
}
