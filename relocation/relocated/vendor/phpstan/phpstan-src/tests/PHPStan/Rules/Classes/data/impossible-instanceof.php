<?php

namespace TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf;

interface Foo
{
}
interface Bar
{
}
interface BarChild extends \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Bar
{
}
class Lorem
{
}
class Ipsum extends \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Lorem
{
}
class Dolor
{
}
class FooImpl implements \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo
{
}
class Test
{
    public function doTest(\TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo $foo, \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Bar $bar, \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Lorem $lorem, \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Ipsum $ipsum, \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Dolor $dolor, \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\FooImpl $fooImpl, \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\BarChild $barChild)
    {
        if ($foo instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Bar) {
        }
        if ($bar instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo) {
        }
        if ($lorem instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Lorem) {
        }
        if ($lorem instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Ipsum) {
        }
        if ($ipsum instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Lorem) {
        }
        if ($ipsum instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Ipsum) {
        }
        if ($dolor instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Lorem) {
        }
        if ($fooImpl instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo) {
        }
        if ($barChild instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Bar) {
        }
        /** @var Collection|mixed[] $collection */
        $collection = doFoo();
        if ($collection instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo) {
        }
        /** @var object $object */
        $object = doFoo();
        if ($object instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo) {
        }
        $str = 'str';
        if ($str instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo) {
        }
        if ($str instanceof $str) {
        }
        if ($foo instanceof $str) {
        }
        $self = new self();
        if ($self instanceof self) {
        }
    }
    public function foreachWithTypeChange()
    {
        $foo = null;
        foreach ([] as $val) {
            if ($foo instanceof self) {
            }
            if ($foo instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Lorem) {
            }
            $foo = new self();
            if ($foo instanceof self) {
            }
        }
    }
    public function whileWithTypeChange()
    {
        $foo = null;
        while (fetch()) {
            if ($foo instanceof self) {
            }
            if ($foo instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Lorem) {
            }
            $foo = new self();
            if ($foo instanceof self) {
            }
        }
    }
    public function forWithTypeChange()
    {
        $foo = null;
        for (;;) {
            if ($foo instanceof self) {
            }
            if ($foo instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Lorem) {
            }
            $foo = new self();
            if ($foo instanceof self) {
            }
        }
    }
}
interface Collection extends \IteratorAggregate
{
}
final class FinalClassWithInvoke
{
    public function __invoke()
    {
    }
}
final class FinalClassWithoutInvoke
{
}
class ClassWithInvoke
{
    public function __invoke()
    {
    }
    public function doFoo(callable $callable, \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo $foo)
    {
        if ($callable instanceof self) {
        }
        if ($callable instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\FinalClassWithInvoke) {
        }
        if ($callable instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\FinalClassWithoutInvoke) {
        }
        if ($callable instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo) {
        }
        if ($callable instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Lorem) {
        }
    }
}
class EliminateCompoundTypes
{
    /**
     * @param Lorem|Dolor $union
     * @param Foo&Bar $intersection
     */
    public function doFoo($union, $intersection)
    {
        if ($union instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Lorem || $union instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Dolor) {
        } elseif ($union instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Lorem) {
        }
        if ($intersection instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo && $intersection instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Bar) {
        } elseif ($intersection instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo) {
        }
        if ($intersection instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo) {
        } elseif ($intersection instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Bar) {
        }
    }
}
class InstanceOfString
{
    /**
     * @param Foo|Bar|null $fooBarNull
     */
    public function doFoo($fooBarNull)
    {
        $string = 'Foo';
        if (\rand(0, 1) === 1) {
            $string = 'Bar';
        }
        if ($fooBarNull instanceof $string) {
            return;
        }
    }
}
trait TraitWithInstanceOfThis
{
    public function doFoo()
    {
        if ($this instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo) {
        }
    }
}
class ClassUsingTrait implements \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo
{
    use TraitWithInstanceOfThis;
}
function (\Iterator $arg) {
    foreach ($arg as $key => $value) {
        \assert($key instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo);
    }
};
class ObjectSubtracted
{
    /**
     * @param object $object
     */
    public function doBar($object)
    {
        if ($object instanceof \Exception) {
            return;
        }
        if ($object instanceof \Exception) {
        }
        if ($object instanceof \InvalidArgumentException) {
        }
    }
    public function doBaz(\TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Bar $bar)
    {
        if ($bar instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\BarChild) {
            return;
        }
        if ($bar instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\BarChild) {
        }
        if ($bar instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\BarGrandChild) {
        }
    }
}
class BarGrandChild implements \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\BarChild
{
}
class InvalidTypeTest
{
    /**
     * @template ObjectT of InvalidTypeTest
     * @template MixedT
     *
     * @param mixed $subject
     * @param int $int
     * @param object $objectWithoutClass
     * @param InvalidTypeTest $object
     * @param int|InvalidTypeTest $intOrObject
     * @param string $string
     * @param mixed $mixed
     * @param mixed $mixed
     * @param ObjectT $objectT
     * @param MixedT $mixedT
     */
    public function doTest($int, $objectWithoutClass, $object, $intOrObject, $string, $mixed, $objectT, $mixedT)
    {
        if ($mixed instanceof $int) {
        }
        if ($mixed instanceof $objectWithoutClass) {
        }
        if ($mixed instanceof $object) {
        }
        if ($mixed instanceof $intOrObject) {
        }
        if ($mixed instanceof $string) {
        }
        if ($mixed instanceof $mixed) {
        }
        if ($mixed instanceof $objectT) {
        }
        if ($mixed instanceof $mixedT) {
        }
    }
}
class CheckInstanceofInIterableForeach
{
    /**
     * @param iterable<Foo> $items
     */
    public function test(iterable $items) : void
    {
        foreach ($items as $item) {
            if (!$item instanceof \TenantCloud\BetterReflection\Relocated\ImpossibleInstanceOf\Foo) {
                throw new \Exception('Unsupported');
            }
        }
    }
}
class CheckInstanceofWithTemplates
{
    /**
     * @template T of \Exception
     * @param T $e
     */
    public function test(\Throwable $t, $e) : void
    {
        if ($t instanceof $e) {
            return;
        }
        if ($e instanceof $t) {
            return;
        }
    }
}
class CheckGenericClassString
{
    /**
     * @param \DateTimeInterface $a
     * @param class-string<\DateTimeInterface> $b
     * @param class-string<\DateTimeInterface> $c
     */
    function test($a, $b, $c) : void
    {
        if ($a instanceof $b) {
            return;
        }
        if ($b instanceof $a) {
            return;
        }
        if ($b instanceof $c) {
            return;
        }
    }
}
class CheckGenericClassStringWithConstantString
{
    /**
     * @param class-string<\DateTimeInterface> $a
     * @param \DateTimeInterface $b
     */
    function test($a, $b) : void
    {
        $t = \DateTimeInterface::class;
        if ($a instanceof $t) {
            return;
        }
        if ($b instanceof $t) {
            return;
        }
    }
}
class CheckInstanceOfLsp
{
    function test(\DateTimeInterface $a, \DateTimeInterface $b) : void
    {
        if ($a instanceof $b) {
            return;
        }
        if ($b instanceof $a) {
            return;
        }
    }
}
