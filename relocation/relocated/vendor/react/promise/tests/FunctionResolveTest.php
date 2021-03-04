<?php

namespace TenantCloud\BetterReflection\Relocated\React\Promise;

class FunctionResolveTest extends \TenantCloud\BetterReflection\Relocated\React\Promise\TestCase
{
    /** @test */
    public function shouldResolveAnImmediateValue()
    {
        $expected = 123;
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo($expected));
        resolve($expected)->then($mock, $this->expectCallableNever());
    }
    /** @test */
    public function shouldResolveAFulfilledPromise()
    {
        $expected = 123;
        $resolved = new \TenantCloud\BetterReflection\Relocated\React\Promise\FulfilledPromise($expected);
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo($expected));
        resolve($resolved)->then($mock, $this->expectCallableNever());
    }
    /** @test */
    public function shouldResolveAThenable()
    {
        $thenable = new \TenantCloud\BetterReflection\Relocated\React\Promise\SimpleFulfilledTestThenable();
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo('foo'));
        resolve($thenable)->then($mock, $this->expectCallableNever());
    }
    /** @test */
    public function shouldResolveACancellableThenable()
    {
        $thenable = new \TenantCloud\BetterReflection\Relocated\React\Promise\SimpleTestCancellableThenable();
        $promise = resolve($thenable);
        $promise->cancel();
        $this->assertTrue($thenable->cancelCalled);
    }
    /** @test */
    public function shouldRejectARejectedPromise()
    {
        $expected = 123;
        $resolved = new \TenantCloud\BetterReflection\Relocated\React\Promise\RejectedPromise($expected);
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo($expected));
        resolve($resolved)->then($this->expectCallableNever(), $mock);
    }
    /** @test */
    public function shouldSupportDeepNestingInPromiseChains()
    {
        $d = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred();
        $d->resolve(\false);
        $result = resolve(resolve($d->promise()->then(function ($val) {
            $d = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred();
            $d->resolve($val);
            $identity = function ($val) {
                return $val;
            };
            return resolve($d->promise()->then($identity))->then(function ($val) {
                return !$val;
            });
        })));
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo(\true));
        $result->then($mock);
    }
    /** @test */
    public function shouldSupportVeryDeepNestedPromises()
    {
        $deferreds = [];
        // @TODO Increase count once global-queue is merged
        for ($i = 0; $i < 10; $i++) {
            $deferreds[] = $d = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred();
            $p = $d->promise();
            $last = $p;
            for ($j = 0; $j < 10; $j++) {
                $last = $last->then(function ($result) {
                    return $result;
                });
            }
        }
        $p = null;
        foreach ($deferreds as $d) {
            if ($p) {
                $d->resolve($p);
            }
            $p = $d->promise();
        }
        $deferreds[0]->resolve(\true);
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo(\true));
        $deferreds[0]->promise()->then($mock);
    }
    /** @test */
    public function returnsExtendePromiseForSimplePromise()
    {
        $promise = $this->getMockBuilder('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\PromiseInterface')->getMock();
        $this->assertInstanceOf('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\ExtendedPromiseInterface', resolve($promise));
    }
}
