<?php

namespace TenantCloud\BetterReflection\Relocated\MethodSignature;

class Animal
{
}
class Dog extends \TenantCloud\BetterReflection\Relocated\MethodSignature\Animal
{
}
class Cat extends \TenantCloud\BetterReflection\Relocated\MethodSignature\Animal
{
}
class BaseClass
{
    /**
     * @param Animal $animal
     */
    public function __construct($animal)
    {
    }
    public function parameterTypeTest1()
    {
    }
    /**
     * @param Animal $animal
     */
    public function parameterTypeTest2($animal)
    {
    }
    /**
     * @param Dog $animal
     */
    public function parameterTypeTest3($animal)
    {
    }
    /**
     * @param Animal $animal
     */
    public function parameterTypeTest4($animal)
    {
    }
    /**
     * @param Cat $animal
     */
    public function parameterTypeTest5($animal)
    {
    }
    /**
     * @param Animal $animal
     */
    public function parameterTypeTest6($animal)
    {
    }
    /**
     * @param Animal $animal
     */
    public function parameterTypeTest7($animal)
    {
    }
    /**
     * @param Animal $animal
     */
    public function parameterTypeTest8($animal)
    {
    }
    /**
     * @return void
     */
    public function returnTypeTest1()
    {
    }
    /**
     * @return Animal
     */
    public function returnTypeTest2()
    {
    }
    /**
     * @return Animal
     */
    public function returnTypeTest3()
    {
    }
    /**
     * @return Dog
     */
    public function returnTypeTest4()
    {
    }
    /**
     * @return Dog
     */
    public function returnTypeTest5()
    {
    }
    /**
     * @return Animal|null
     */
    public function returnTypeTest6()
    {
    }
    /**
     * @return mixed
     */
    public function returnTypeTest7()
    {
    }
    /**
     * @return mixed
     */
    public function returnTypeTest8()
    {
    }
    /**
     * @return mixed
     */
    public function returnTypeTest9()
    {
    }
}
interface BaseInterface
{
    /**
     * @param Animal $animal
     */
    public function __construct($animal);
    public function parameterTypeTest1();
    /**
     * @param Animal $animal
     */
    public function parameterTypeTest2($animal);
    /**
     * @param Dog $animal
     */
    public function parameterTypeTest3($animal);
    /**
     * @param Animal $animal
     */
    public function parameterTypeTest4($animal);
    /**
     * @param Cat $animal
     */
    public function parameterTypeTest5($animal);
    /**
     * @param Animal $animal
     */
    public function parameterTypeTest6($animal);
    /**
     * @param Animal $animal
     */
    public function parameterTypeTest7($animal);
    /**
     * @param Animal $animal
     */
    public function parameterTypeTest8($animal);
    /**
     * @return void
     */
    public function returnTypeTest1();
    /**
     * @return Animal
     */
    public function returnTypeTest2();
    /**
     * @return Animal
     */
    public function returnTypeTest3();
    /**
     * @return Dog
     */
    public function returnTypeTest4();
    /**
     * @return Dog
     */
    public function returnTypeTest5();
    /**
     * @return Animal|null
     */
    public function returnTypeTest6();
    public function returnTypeTest7();
    /**
     * @return mixed
     */
    public function returnTypeTest8();
    public function returnTypeTest9();
}
class BaseClassWithPrivateMethods
{
    /**
     * @param Animal $animal
     */
    private function parameterTypeTest1($animal)
    {
    }
    /**
     * @return Animal
     */
    private function returnTypeTest1()
    {
    }
    /**
     * @param Animal $animal
     */
    private function parameterTypeTest2($animal)
    {
    }
    /**
     * @return Animal
     */
    private function returnTypeTest2()
    {
    }
}
namespace TenantCloud\BetterReflection\Relocated\MethodSignature;

class SubClass extends \TenantCloud\BetterReflection\Relocated\MethodSignature\BaseClass implements \TenantCloud\BetterReflection\Relocated\MethodSignature\BaseInterface
{
    /**
     * @param Dog $animal
     */
    public function __construct($animal)
    {
    }
    public function parameterTypeTest1()
    {
    }
    /**
     * @param Animal $animal
     */
    public function parameterTypeTest2($animal)
    {
    }
    /**
     * @param Animal $animal
     */
    public function parameterTypeTest3($animal)
    {
    }
    /**
     * @param Dog $animal
     */
    public function parameterTypeTest4($animal)
    {
    }
    /**
     * @param Dog $animal
     */
    public function parameterTypeTest5($animal)
    {
    }
    /**
     * @param Animal|null $animal
     */
    public function parameterTypeTest6($animal)
    {
    }
    public function parameterTypeTest7($animal)
    {
    }
    /**
     * @param mixed $animal
     */
    public function parameterTypeTest8($animal)
    {
    }
    /**
     * @return mixed
     */
    public function returnTypeTest1()
    {
    }
    /**
     * @return Animal
     */
    public function returnTypeTest2()
    {
    }
    /**
     * @return Dog
     */
    public function returnTypeTest3()
    {
    }
    /**
     * @return Animal
     */
    public function returnTypeTest4()
    {
    }
    /**
     * @return Cat
     */
    public function returnTypeTest5()
    {
    }
    /**
     * @return Animal
     */
    public function returnTypeTest6()
    {
    }
    /**
     * @return Animal
     */
    public function returnTypeTest7()
    {
    }
    /**
     * @return Animal
     */
    public function returnTypeTest8()
    {
    }
    /**
     * @return void
     */
    public function returnTypeTest9()
    {
    }
}
abstract class ReturnSomethingElseThenVoid implements \TenantCloud\BetterReflection\Relocated\MethodSignature\BaseInterface
{
    public function returnTypeTest1() : int
    {
        return 1;
    }
}
class SubClassWithPrivateMethods extends \TenantCloud\BetterReflection\Relocated\MethodSignature\BaseClassWithPrivateMethods
{
    /**
     * @param int $animal
     */
    private function parameterTypeTest1($animal)
    {
    }
    /**
     * @return string
     */
    private function returnTypeTest1()
    {
    }
    /**
     * @param int $animal
     */
    public function parameterTypeTest2($animal)
    {
    }
    /**
     * @return string
     */
    public function returnTypeTest2()
    {
    }
}
/**
 * @template TNodeType of \PhpParser\Node
 */
interface GenericRule
{
    /**
     * @param TNodeType $node
     */
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) : void;
}
class Rule implements \TenantCloud\BetterReflection\Relocated\MethodSignature\GenericRule
{
    /**
     * @param \PhpParser\Node\Expr\StaticCall $node
     */
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) : void
    {
    }
}
interface ConstantArrayInterface
{
    /**
     * @return array{foo: string}
     */
    public function foobar() : array;
}
class ConstantArrayClass implements \TenantCloud\BetterReflection\Relocated\MethodSignature\ConstantArrayInterface
{
    /**
     * @return array{foo: string, bar: string}
     */
    public function foobar() : array
    {
        return ['foo' => '', 'bar' => ''];
    }
}
