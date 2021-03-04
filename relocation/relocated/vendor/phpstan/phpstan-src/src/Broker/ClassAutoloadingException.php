<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Broker;

class ClassAutoloadingException extends \TenantCloud\BetterReflection\Relocated\PHPStan\AnalysedCodeException
{
    private string $className;
    public function __construct(string $functionName, ?\Throwable $previous = null)
    {
        if ($previous !== null) {
            parent::__construct(\sprintf('%s (%s) thrown while looking for class %s.', \get_class($previous), $previous->getMessage(), $functionName), 0, $previous);
        } else {
            parent::__construct(\sprintf('Class %s not found.', $functionName), 0);
        }
        $this->className = $functionName;
    }
    public function getClassName() : string
    {
        return $this->className;
    }
    public function getTip() : ?string
    {
        return 'Learn more at https://phpstan.org/user-guide/discovering-symbols';
    }
}
