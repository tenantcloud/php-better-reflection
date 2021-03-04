<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter;

use ReflectionClassConstant as CoreReflectionClassConstant;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClassConstant as BetterReflectionClassConstant;
class ReflectionClassConstant extends \ReflectionClassConstant
{
    /** @var BetterReflectionClassConstant */
    private $betterClassConstant;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClassConstant $betterClassConstant)
    {
        $this->betterClassConstant = $betterClassConstant;
    }
    /**
     * Get the name of the reflection (e.g. if this is a ReflectionClass this
     * will be the class name).
     */
    public function getName() : string
    {
        return $this->betterClassConstant->getName();
    }
    /**
     * Returns constant value
     *
     * @return scalar|array<scalar>|null
     */
    public function getValue()
    {
        return $this->betterClassConstant->getValue();
    }
    /**
     * Constant is public
     */
    public function isPublic() : bool
    {
        return $this->betterClassConstant->isPublic();
    }
    /**
     * Constant is private
     */
    public function isPrivate() : bool
    {
        return $this->betterClassConstant->isPrivate();
    }
    /**
     * Constant is protected
     */
    public function isProtected() : bool
    {
        return $this->betterClassConstant->isProtected();
    }
    /**
     * Returns a bitfield of the access modifiers for this constant
     */
    public function getModifiers() : int
    {
        return $this->betterClassConstant->getModifiers();
    }
    /**
     * Get the declaring class
     */
    public function getDeclaringClass() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionClass
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionClass($this->betterClassConstant->getDeclaringClass());
    }
    /**
     * Returns the doc comment for this constant
     *
     * @return string|false
     */
    public function getDocComment()
    {
        return $this->betterClassConstant->getDocComment() ?: \false;
    }
    /**
     * To string
     *
     * @link https://php.net/manual/en/reflector.tostring.php
     */
    public function __toString() : string
    {
        return $this->betterClassConstant->__toString();
    }
}
