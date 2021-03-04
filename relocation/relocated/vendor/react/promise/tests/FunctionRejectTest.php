<?php

namespace TenantCloud\BetterReflection\Relocated\React\Promise;

class FunctionRejectTest extends \TenantCloud\BetterReflection\Relocated\React\Promise\TestCase
{
    /** @test */
    public function shouldRejectAnImmediateValue()
    {
        $expected = 123;
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo($expected));
        reject($expected)->then($this->expectCallableNever(), $mock);
    }
    /** @test */
    public function shouldRejectAFulfilledPromise()
    {
        $expected = 123;
        $resolved = new \TenantCloud\BetterReflection\Relocated\React\Promise\FulfilledPromise($expected);
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo($expected));
        reject($resolved)->then($this->expectCallableNever(), $mock);
    }
    /** @test */
    public function shouldRejectARejectedPromise()
    {
        $expected = 123;
        $resolved = new \TenantCloud\BetterReflection\Relocated\React\Promise\RejectedPromise($expected);
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo($expected));
        reject($resolved)->then($this->expectCallableNever(), $mock);
    }
}
