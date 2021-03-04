<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Abc;

/**
 * Interface
 * @author John Doe
 */
interface Interface1
{
    public function func1();
}
interface Interface2
{
}
abstract class Class1 implements \TenantCloud\BetterReflection\Relocated\Abc\Interface1
{
    /** @return Class1 */
    public function func1()
    {
    }
    protected abstract function func2();
}
class Class2 extends \TenantCloud\BetterReflection\Relocated\Abc\Class1 implements \TenantCloud\BetterReflection\Relocated\Abc\Interface2
{
    /**
     * Public
     * @var int
     */
    public $public;
    /** @var int */
    protected $protected = 10;
    private $private = [];
    public static $static;
    /**
     * Func3
     * @return Class1
     */
    private function &func3(array $a = [], \TenantCloud\BetterReflection\Relocated\Abc\Class2 $b = null, \TenantCloud\BetterReflection\Relocated\Abc\Unknown $c, \TenantCloud\BetterReflection\Relocated\Xyz\Unknown $d, callable $e, $f = \TenantCloud\BetterReflection\Relocated\Abc\Unknown::ABC, $g)
    {
    }
    public final function func2()
    {
    }
}
class Class3
{
    public $prop1;
}
class Class4
{
    const THE_CONSTANT = 9;
}
/** */
class Class5
{
    public function func1(\TenantCloud\BetterReflection\Relocated\A $a, ?\TenantCloud\BetterReflection\Relocated\B $b, ?\TenantCloud\BetterReflection\Relocated\C $c = null, \TenantCloud\BetterReflection\Relocated\D $d = null, \TenantCloud\BetterReflection\Relocated\E $e, ?int $i = 1, ?array $arr = [])
    {
    }
    public function func2() : ?\stdClass
    {
    }
    public function func3() : void
    {
    }
}
class Class6 extends \TenantCloud\BetterReflection\Relocated\Abc\Class4
{
    /** const doc */
    private const THE_PRIVATE_CONSTANT = 9;
    public const THE_PUBLIC_CONSTANT = 9;
}
