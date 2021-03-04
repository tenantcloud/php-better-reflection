<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\InheritDocMergingVar;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class A
{
}
class B extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingVar\A
{
}
class One
{
    /** @var A */
    protected $property;
    public function method() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingVar\\A', $this->property);
    }
}
class Two extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingVar\One
{
    /** @var B */
    protected $property;
    public function method() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingVar\\B', $this->property);
    }
}
class Three extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingVar\Two
{
    /** Some comment */
    protected $property;
    public function method() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingVar\\B', $this->property);
    }
}
class Four extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingVar\Three
{
    protected $property;
    public function method() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingVar\\B', $this->property);
    }
}
class Five extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingVar\Four
{
    public function method() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingVar\\B', $this->property);
    }
}
class Six extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingVar\Five
{
    protected $property;
    public function method() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingVar\\B', $this->property);
    }
}
class Seven extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingVar\One
{
    /**
     * @inheritDoc
     * @var B
     */
    protected $property;
}
/**
 * @template T of object
 */
class ClassWithTemplate
{
    /** @var T */
    protected $prop;
}
class ChildClassExtendingClassWithTemplate extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingVar\ClassWithTemplate
{
    protected $prop;
    public function doFoo()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $this->prop);
    }
}
/**
 * @extends ClassWithTemplate<\stdClass>
 */
class ChildClass2ExtendingClassWithTemplate extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingVar\ClassWithTemplate
{
    /** someComment */
    protected $prop;
    public function doFoo()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $this->prop);
    }
}
