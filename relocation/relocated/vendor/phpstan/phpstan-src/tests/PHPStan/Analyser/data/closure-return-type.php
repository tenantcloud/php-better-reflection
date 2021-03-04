<?php

namespace TenantCloud\BetterReflection\Relocated\ClosureReturnType;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(int $i) : void
    {
        $f = function () {
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('void', $f());
        $f = function () {
            return;
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('void', $f());
        $f = function () {
            return 1;
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $f());
        $f = function () : array {
            return ['foo' => 'bar'];
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'foo\' => \'bar\')', $f());
        $f = function (string $s) {
            return $s;
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $f('foo'));
        $f = function () use($i) {
            return $i;
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $f());
        $f = function () use($i) {
            if (\rand(0, 1)) {
                return $i;
            }
            return null;
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|null', $f());
        $f = function () use($i) {
            if (\rand(0, 1)) {
                return $i;
            }
            return;
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|null', $f());
        $f = function () {
            (yield 1);
            return 2;
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Generator<int, 1, mixed, 2>', $f());
        $g = function () use($f) {
            yield from $f();
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Generator<int, 1, mixed, void>', $g());
        $h = function () : \Generator {
            (yield 1);
            return 2;
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Generator<int, 1, mixed, 2>', $h());
    }
    public function doBar() : void
    {
        $f = function () {
            if (\rand(0, 1)) {
                return 1;
            }
            function () {
                return 'foo';
            };
            $c = new class
            {
                public function doFoo()
                {
                    return 2.0;
                }
            };
            return 2;
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2', $f());
    }
    /**
     * @return never
     */
    public function returnNever() : void
    {
    }
    public function doBaz() : void
    {
        $f = function () {
            $this->returnNever();
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $f());
        $f = function () : void {
            $this->returnNever();
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $f());
        $f = function () {
            if (\rand(0, 1)) {
                return;
            }
            $this->returnNever();
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('void', $f());
        $f = function (array $a) {
            foreach ($a as $v) {
                continue;
            }
            $this->returnNever();
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $f([]));
        $f = function (array $a) {
            foreach ($a as $v) {
                $this->returnNever();
            }
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('void', $f([]));
        $f = function () {
            foreach ([1, 2, 3] as $v) {
                $this->returnNever();
            }
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $f());
        $f = function () : \stdClass {
            throw new \Exception();
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $f());
    }
}
