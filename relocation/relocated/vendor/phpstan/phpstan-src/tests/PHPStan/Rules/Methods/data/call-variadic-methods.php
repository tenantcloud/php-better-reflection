<?php

namespace TenantCloud\BetterReflection\Relocated\CallVariadicMethods;

class Foo
{
    public function bar()
    {
        $this->baz();
        $this->lorem();
        $this->baz(1, 2, 3);
        $this->lorem(1, 2, 3);
    }
    public function baz($foo, ...$bar)
    {
    }
    public function lorem($foo, $bar)
    {
        $foo = 'bar';
        if ($foo) {
            \func_get_args();
        }
    }
    public function doFoo()
    {
        $this->doVariadicString(1, 'foo', 'bar');
        $this->doVariadicString(1, 2, 3);
        $this->doVariadicString(1);
        $this->doVariadicString('foo');
        $this->doVariadicWithFuncGetArgs('foo', 'bar');
        $strings = ['foo', 'bar', 'baz'];
        $this->doVariadicString(1, ...$strings);
        $this->doVariadicString(1, 'foo', ...$strings);
        $integers = [1, 2, 3];
        $this->doVariadicString(1, 'foo', 1, ...$integers);
        $this->doIntegerParameters(...$strings);
        $this->doIntegerParameters(...$integers);
    }
    public function doVariadicString(int $int, string ...$strings)
    {
    }
    public function doVariadicWithFuncGetArgs()
    {
        \func_get_args();
    }
    public function doIntegerParameters(int $foo, int $bar)
    {
    }
}
class Bar
{
    /**
     * @param string[] ...$strings
     */
    function variadicStrings(string ...$strings)
    {
    }
    /**
     * @param string[] ...$strings
     */
    function anotherVariadicStrings(...$strings)
    {
    }
    public function doFoo()
    {
        $this->variadicStrings(1, 2);
        $this->variadicStrings('foo', 'bar');
        $this->anotherVariadicStrings(1, 2);
        $this->anotherVariadicStrings('foo', 'bar');
    }
}
