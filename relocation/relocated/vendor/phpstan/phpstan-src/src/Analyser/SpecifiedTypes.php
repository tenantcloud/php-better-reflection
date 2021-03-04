<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
class SpecifiedTypes
{
    /** @var mixed[] */
    private array $sureTypes;
    /** @var mixed[] */
    private array $sureNotTypes;
    private bool $overwrite;
    /**
     * @param mixed[] $sureTypes
     * @param mixed[] $sureNotTypes
     * @param bool $overwrite
     */
    public function __construct(array $sureTypes = [], array $sureNotTypes = [], bool $overwrite = \false)
    {
        $this->sureTypes = $sureTypes;
        $this->sureNotTypes = $sureNotTypes;
        $this->overwrite = $overwrite;
    }
    /**
     * @return mixed[]
     */
    public function getSureTypes() : array
    {
        return $this->sureTypes;
    }
    /**
     * @return mixed[]
     */
    public function getSureNotTypes() : array
    {
        return $this->sureNotTypes;
    }
    public function shouldOverwrite() : bool
    {
        return $this->overwrite;
    }
    public function intersectWith(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes $other) : self
    {
        $sureTypeUnion = [];
        $sureNotTypeUnion = [];
        foreach ($this->sureTypes as $exprString => [$exprNode, $type]) {
            if (!isset($other->sureTypes[$exprString])) {
                continue;
            }
            $sureTypeUnion[$exprString] = [$exprNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($type, $other->sureTypes[$exprString][1])];
        }
        foreach ($this->sureNotTypes as $exprString => [$exprNode, $type]) {
            if (!isset($other->sureNotTypes[$exprString])) {
                continue;
            }
            $sureNotTypeUnion[$exprString] = [$exprNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect($type, $other->sureNotTypes[$exprString][1])];
        }
        return new self($sureTypeUnion, $sureNotTypeUnion);
    }
    public function unionWith(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes $other) : self
    {
        $sureTypeUnion = $this->sureTypes + $other->sureTypes;
        $sureNotTypeUnion = $this->sureNotTypes + $other->sureNotTypes;
        foreach ($this->sureTypes as $exprString => [$exprNode, $type]) {
            if (!isset($other->sureTypes[$exprString])) {
                continue;
            }
            $sureTypeUnion[$exprString] = [$exprNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect($type, $other->sureTypes[$exprString][1])];
        }
        foreach ($this->sureNotTypes as $exprString => [$exprNode, $type]) {
            if (!isset($other->sureNotTypes[$exprString])) {
                continue;
            }
            $sureNotTypeUnion[$exprString] = [$exprNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($type, $other->sureNotTypes[$exprString][1])];
        }
        return new self($sureTypeUnion, $sureNotTypeUnion);
    }
}
