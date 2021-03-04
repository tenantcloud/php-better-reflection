<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class FoundTypeResult
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type;
    /** @var string[] */
    private array $referencedClasses;
    /** @var RuleError[] */
    private array $unknownClassErrors;
    /**
     * @param \PHPStan\Type\Type $type
     * @param string[] $referencedClasses
     * @param RuleError[] $unknownClassErrors
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, array $referencedClasses, array $unknownClassErrors)
    {
        $this->type = $type;
        $this->referencedClasses = $referencedClasses;
        $this->unknownClassErrors = $unknownClassErrors;
    }
    public function getType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->type;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return $this->referencedClasses;
    }
    /**
     * @return RuleError[]
     */
    public function getUnknownClassErrors() : array
    {
        return $this->unknownClassErrors;
    }
}
