<?php

namespace TenantCloud\BetterReflection\Relocated\React\Promise;

class FunctionCheckTypehintTest extends \TenantCloud\BetterReflection\Relocated\React\Promise\TestCase
{
    /** @test */
    public function shouldAcceptClosureCallbackWithTypehint()
    {
        $this->assertTrue(_checkTypehint(function (\InvalidArgumentException $e) {
        }, new \InvalidArgumentException()));
        $this->assertfalse(_checkTypehint(function (\InvalidArgumentException $e) {
        }, new \Exception()));
    }
    /** @test */
    public function shouldAcceptFunctionStringCallbackWithTypehint()
    {
        $this->assertTrue(_checkTypehint('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\testCallbackWithTypehint', new \InvalidArgumentException()));
        $this->assertfalse(_checkTypehint('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\testCallbackWithTypehint', new \Exception()));
    }
    /** @test */
    public function shouldAcceptInvokableObjectCallbackWithTypehint()
    {
        $this->assertTrue(_checkTypehint(new \TenantCloud\BetterReflection\Relocated\React\Promise\TestCallbackWithTypehintClass(), new \InvalidArgumentException()));
        $this->assertfalse(_checkTypehint(new \TenantCloud\BetterReflection\Relocated\React\Promise\TestCallbackWithTypehintClass(), new \Exception()));
    }
    /** @test */
    public function shouldAcceptObjectMethodCallbackWithTypehint()
    {
        $this->assertTrue(_checkTypehint([new \TenantCloud\BetterReflection\Relocated\React\Promise\TestCallbackWithTypehintClass(), 'testCallback'], new \InvalidArgumentException()));
        $this->assertfalse(_checkTypehint([new \TenantCloud\BetterReflection\Relocated\React\Promise\TestCallbackWithTypehintClass(), 'testCallback'], new \Exception()));
    }
    /** @test */
    public function shouldAcceptStaticClassCallbackWithTypehint()
    {
        $this->assertTrue(_checkTypehint(['React\\Promise\\TestCallbackWithTypehintClass', 'testCallbackStatic'], new \InvalidArgumentException()));
        $this->assertfalse(_checkTypehint(['React\\Promise\\TestCallbackWithTypehintClass', 'testCallbackStatic'], new \Exception()));
    }
    /** @test */
    public function shouldAcceptClosureCallbackWithoutTypehint()
    {
        $this->assertTrue(_checkTypehint(function (\InvalidArgumentException $e) {
        }, new \InvalidArgumentException()));
    }
    /** @test */
    public function shouldAcceptFunctionStringCallbackWithoutTypehint()
    {
        $this->assertTrue(_checkTypehint('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\testCallbackWithoutTypehint', new \InvalidArgumentException()));
    }
    /** @test */
    public function shouldAcceptInvokableObjectCallbackWithoutTypehint()
    {
        $this->assertTrue(_checkTypehint(new \TenantCloud\BetterReflection\Relocated\React\Promise\TestCallbackWithoutTypehintClass(), new \InvalidArgumentException()));
    }
    /** @test */
    public function shouldAcceptObjectMethodCallbackWithoutTypehint()
    {
        $this->assertTrue(_checkTypehint([new \TenantCloud\BetterReflection\Relocated\React\Promise\TestCallbackWithoutTypehintClass(), 'testCallback'], new \InvalidArgumentException()));
    }
    /** @test */
    public function shouldAcceptStaticClassCallbackWithoutTypehint()
    {
        $this->assertTrue(_checkTypehint(['React\\Promise\\TestCallbackWithoutTypehintClass', 'testCallbackStatic'], new \InvalidArgumentException()));
    }
}
function testCallbackWithTypehint(\InvalidArgumentException $e)
{
}
function testCallbackWithoutTypehint()
{
}
class TestCallbackWithTypehintClass
{
    public function __invoke(\InvalidArgumentException $e)
    {
    }
    public function testCallback(\InvalidArgumentException $e)
    {
    }
    public static function testCallbackStatic(\InvalidArgumentException $e)
    {
    }
}
class TestCallbackWithoutTypehintClass
{
    public function __invoke()
    {
    }
    public function testCallback()
    {
    }
    public static function testCallbackStatic()
    {
    }
}
