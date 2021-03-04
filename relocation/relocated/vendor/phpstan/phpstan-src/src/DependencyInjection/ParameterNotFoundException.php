<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection;

class ParameterNotFoundException extends \Exception
{
    public function __construct(string $parameterName)
    {
        parent::__construct(\sprintf('Parameter %s not found in the container.', $parameterName));
    }
}
