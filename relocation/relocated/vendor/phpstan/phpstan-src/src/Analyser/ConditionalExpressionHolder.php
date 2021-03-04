<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class ConditionalExpressionHolder
{
    /** @var array<string, Type> */
    private array $conditionExpressionTypes;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\VariableTypeHolder $typeHolder;
    /**
     * @param array<string, Type> $conditionExpressionTypes
     * @param VariableTypeHolder $typeHolder
     */
    public function __construct(array $conditionExpressionTypes, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\VariableTypeHolder $typeHolder)
    {
        if (\count($conditionExpressionTypes) === 0) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $this->conditionExpressionTypes = $conditionExpressionTypes;
        $this->typeHolder = $typeHolder;
    }
    /**
     * @return array<string, Type>
     */
    public function getConditionExpressionTypes() : array
    {
        return $this->conditionExpressionTypes;
    }
    public function getTypeHolder() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\VariableTypeHolder
    {
        return $this->typeHolder;
    }
    public function getKey() : string
    {
        $parts = [];
        foreach ($this->conditionExpressionTypes as $exprString => $type) {
            $parts[] = $exprString . '=' . $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise());
        }
        return \sprintf('%s => %s (%s)', \implode(' && ', $parts), $this->typeHolder->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $this->typeHolder->getCertainty()->describe());
    }
}
