<?php

// lint >= 7.4
namespace TenantCloud\BetterReflection\Relocated\UninitializedProperty;

class Foo
{
    private int $foo;
    private int $bar;
    private int $baz;
    public function __construct()
    {
        $this->foo = 1;
    }
    public function setBaz()
    {
        $this->baz = 1;
    }
}
class Bar
{
    private int $foo;
    public function __construct()
    {
        $this->foo += 1;
        $this->foo = 2;
    }
}
class Baz
{
    private int $foo;
    public function __construct()
    {
        $this->foo = 2;
        $this->foo += 1;
    }
}
class Lorem
{
    private int $foo;
    private int $bar;
    private int $baz;
    private int $lorem;
    private int $ipsum;
    private function assign()
    {
        $this->bar = 2;
        $this->assignAgain();
        self::assignAgainAgain();
    }
    public function __construct()
    {
        $this->foo = 1;
        $this->assign();
    }
    private function assignAgain()
    {
        $this->lorem = 4;
    }
    private function assignAgainAgain()
    {
        $this->ipsum = 5;
    }
    public function notCalled()
    {
        $this->baz = 3;
    }
}
class TestCase
{
    protected function setUp()
    {
    }
}
class MyTestCase extends \TenantCloud\BetterReflection\Relocated\UninitializedProperty\TestCase
{
    private int $foo;
    protected function setUp()
    {
        $this->foo = 1;
    }
}
class TestExtension
{
    private int $inited;
    private int $uninited;
}
