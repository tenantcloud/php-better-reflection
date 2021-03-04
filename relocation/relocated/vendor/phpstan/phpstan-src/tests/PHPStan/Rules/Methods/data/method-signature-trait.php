<?php

namespace TenantCloud\BetterReflection\Relocated\MethodSignature;

class SubClassUsingTrait extends \TenantCloud\BetterReflection\Relocated\MethodSignature\BaseClass implements \TenantCloud\BetterReflection\Relocated\MethodSignature\BaseInterface
{
    use SubTrait;
}
trait SubTrait
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
