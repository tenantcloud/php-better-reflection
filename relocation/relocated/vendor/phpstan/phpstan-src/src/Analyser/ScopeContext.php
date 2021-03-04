<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
class ScopeContext
{
    private string $file;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $traitReflection;
    private function __construct(string $file, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $traitReflection)
    {
        $this->file = $file;
        $this->classReflection = $classReflection;
        $this->traitReflection = $traitReflection;
    }
    public static function create(string $file) : self
    {
        return new self($file, null, null);
    }
    public function beginFile() : self
    {
        return new self($this->file, null, null);
    }
    public function enterClass(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection) : self
    {
        if ($this->classReflection !== null && !$classReflection->isAnonymous()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        if ($classReflection->isTrait()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return new self($this->file, $classReflection, null);
    }
    public function enterTrait(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $traitReflection) : self
    {
        if ($this->classReflection === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        if (!$traitReflection->isTrait()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return new self($this->file, $this->classReflection, $traitReflection);
    }
    public function equals(self $otherContext) : bool
    {
        if ($this->file !== $otherContext->file) {
            return \false;
        }
        if ($this->getClassReflection() === null) {
            return $otherContext->getClassReflection() === null;
        } elseif ($otherContext->getClassReflection() === null) {
            return \false;
        }
        $isSameClass = $this->getClassReflection()->getName() === $otherContext->getClassReflection()->getName();
        if ($this->getTraitReflection() === null) {
            return $otherContext->getTraitReflection() === null && $isSameClass;
        } elseif ($otherContext->getTraitReflection() === null) {
            return \false;
        }
        $isSameTrait = $this->getTraitReflection()->getName() === $otherContext->getTraitReflection()->getName();
        return $isSameClass && $isSameTrait;
    }
    public function getFile() : string
    {
        return $this->file;
    }
    public function getClassReflection() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->classReflection;
    }
    public function getTraitReflection() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->traitReflection;
    }
}
