<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
class ThisType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType $staticObjectType = null;
    /**
     * @param string|ClassReflection $classReflection
     */
    public function __construct($classReflection)
    {
        if (\is_string($classReflection)) {
            $classReflection = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance()->getClass($classReflection);
        }
        parent::__construct($classReflection->getName());
        $this->classReflection = $classReflection;
    }
    public function getStaticObjectType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType
    {
        if ($this->staticObjectType === null) {
            if ($this->classReflection->isGeneric()) {
                $typeMap = $this->classReflection->getTemplateTypeMap()->map(static function (string $name, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
                    return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::toArgument($type);
                });
                return $this->staticObjectType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType($this->classReflection->getName(), $this->classReflection->typeMapToList($typeMap));
            }
            return $this->staticObjectType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($this->classReflection->getName(), null, $this->classReflection);
        }
        return $this->staticObjectType;
    }
    public function changeBaseClass(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType
    {
        return new self($classReflection);
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('$this(%s)', $this->getClassName());
    }
}
