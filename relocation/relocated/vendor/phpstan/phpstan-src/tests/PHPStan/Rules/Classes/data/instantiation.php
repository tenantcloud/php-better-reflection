<?php

// lint < 8.0
namespace TenantCloud\BetterReflection\Relocated\TestInstantiation;

class InstantiatingClass
{
    public function __construct(int $i)
    {
    }
    public function doFoo()
    {
        new self();
        new self(1);
        new static();
        // not checked
        new parent();
    }
}
function () {
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\FooInstantiation();
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\FooInstantiation();
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\FooInstantiation(1);
    // additional parameter
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\FooBarInstantiation();
    // nonexistent
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\BarInstantiation();
    // missing parameter
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\LoremInstantiation();
    // abstract
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\IpsumInstantiation();
    // interface
    $test = 'Test';
    new $test();
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\ClassWithVariadicConstructor(1, 2, 3);
    new \DatePeriod();
    new \DatePeriod(new \DateTime(), new \DateInterval('P1D'), new \DateTime(), \DatePeriod::EXCLUDE_START_DATE);
    new self();
    new static();
    new parent();
    $a = new \TenantCloud\BetterReflection\Relocated\TestInstantiation\BarInstantiation(1);
    new $a();
};
class ChildInstantiatingClass extends \TenantCloud\BetterReflection\Relocated\TestInstantiation\InstantiatingClass
{
    public function __construct(int $i, int $j)
    {
        parent::__construct($i);
    }
    public function doBar()
    {
        new parent();
        new parent(1);
    }
}
function () {
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\FOOInstantiation(1, 2, 3);
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\BARInstantiation();
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\BARInstantiation(1);
};
class PrivateConstructorClass
{
    private function __construct(int $i)
    {
    }
}
class ProtectedConstructorClass
{
    protected function __construct(int $i)
    {
    }
}
class ClassExtendsProtectedConstructorClass extends \TenantCloud\BetterReflection\Relocated\TestInstantiation\ProtectedConstructorClass
{
    public function doFoo()
    {
        new self();
    }
}
class ExtendsPrivateConstructorClass extends \TenantCloud\BetterReflection\Relocated\TestInstantiation\PrivateConstructorClass
{
    public function doFoo()
    {
        new self();
    }
}
function () {
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\PrivateConstructorClass(1);
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\ProtectedConstructorClass(1);
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\ClassExtendsProtectedConstructorClass(1);
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\ExtendsPrivateConstructorClass(1);
};
function () {
    new \Exception(123, 'code');
};
class NoConstructor
{
}
function () {
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\NoConstructor();
    new \TenantCloud\BetterReflection\Relocated\TestInstantiation\NOCONSTRUCTOR();
};
function () {
    new class(1)
    {
        public function __construct($i)
        {
        }
    };
    new class(1, 2, 3)
    {
        public function __construct($i)
        {
        }
    };
};
class DoWhileVariableReassignment
{
    public function doFoo()
    {
        $arr = [];
        do {
            $arr = new self($arr);
        } while ($arr = [1]);
    }
    public function __construct(array $arr)
    {
    }
}
class ClassInExpression
{
    public static function doFoo(string $key) : void
    {
        $a = 'UndefinedClass1';
        new $a();
        $b = ['UndefinedClass2'];
        new $b[0]();
        $classes = ['key1' => self::class, 'key2' => 'UndefinedClass3'];
        new $classes[$key]();
    }
}
final class FinalClass
{
    public function doFoo()
    {
        new static();
        new static(1);
    }
}
class ClassWithFinalConstructor
{
    public final function __construct(int $i)
    {
    }
    public function doFoo()
    {
        new static(1);
        new static();
    }
}
interface InterfaceWithConstructor
{
    public function __construct(int $i);
}
class ConstructorComingFromAnInterface implements \TenantCloud\BetterReflection\Relocated\TestInstantiation\InterfaceWithConstructor
{
    public function __construct(int $i)
    {
    }
    public function doFoo()
    {
        new static(1);
        new static();
    }
}
abstract class AbstractClassWithFinalConstructor
{
    protected final function __construct()
    {
    }
    public function getInstance()
    {
        new static();
        new static(1);
    }
}
abstract class AbstractConstructor
{
    public abstract function __construct(string $s);
    public function doFoo()
    {
        new static('foo');
        new static();
    }
}
class ClassExtendingAbstractConstructor extends \TenantCloud\BetterReflection\Relocated\TestInstantiation\AbstractConstructor
{
    public function __construct(string $s)
    {
    }
    public function doBar()
    {
        new static('foo');
        new static();
    }
}
