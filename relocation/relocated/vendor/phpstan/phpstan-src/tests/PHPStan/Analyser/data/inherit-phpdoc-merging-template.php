<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\InheritDocMergingTemplate;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @template T
     * @template U
     * @param T $a
     * @param U $b
     * @return T|array<U>
     */
    public function doFoo($a, $b)
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingTemplate\Foo
{
    public function doFoo($a, $b)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (method InheritDocMergingTemplate\\Foo::doFoo(), argument)', $a);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('U (method InheritDocMergingTemplate\\Foo::doFoo(), argument)', $b);
    }
    public function doBar()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>|int', $this->doFoo(1, 'hahaha'));
    }
}
class Dolor extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingTemplate\Foo
{
    /**
     * @param T $a
     * @param U $b
     * @return T|array<U>
     */
    public function doFoo($a, $b)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingTemplate\\T', $a);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingTemplate\\U', $b);
    }
    public function doBar()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\array<InheritDocMergingTemplate\\U>|InheritDocMergingTemplate\\T', $this->doFoo(1, 'hahaha'));
    }
}
class Sit extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingTemplate\Foo
{
    /**
     * @template T
     * @param T $a
     * @param U $b
     * @return T|array<U>
     */
    public function doFoo($a, $b)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (method InheritDocMergingTemplate\\Sit::doFoo(), argument)', $a);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocMergingTemplate\\U', $b);
    }
    public function doBar()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<InheritDocMergingTemplate\\U>|int', $this->doFoo(1, 'hahaha'));
    }
}
class Amet extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingTemplate\Foo
{
    /** SomeComment */
    public function doFoo($a, $b)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (method InheritDocMergingTemplate\\Foo::doFoo(), argument)', $a);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('U (method InheritDocMergingTemplate\\Foo::doFoo(), argument)', $b);
    }
    public function doBar()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>|int', $this->doFoo(1, 'hahaha'));
    }
}
/**
 * @template T of object
 */
class Baz
{
    /**
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}
class Lorem extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingTemplate\Baz
{
    public function doFoo($a)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $a);
    }
}
/**
 * @extends Baz<\stdClass>
 */
class Ipsum extends \TenantCloud\BetterReflection\Relocated\InheritDocMergingTemplate\Baz
{
    public function doFoo($a)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $a);
    }
}
