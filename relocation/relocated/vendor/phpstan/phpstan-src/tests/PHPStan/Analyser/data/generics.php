<?php

namespace TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType;

use IteratorAggregate;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\GenericRule;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @template T
 * @param T $a
 * @return T
 */
function a($a)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (function PHPStan\\Generics\\FunctionsAssertType\\a(), argument)', $a);
    return $a;
}
/**
 * @param int $int
 * @param int|float $intFloat
 * @param mixed $mixed
 */
function testA($int, $intFloat, $mixed)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', a($int));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float|int', a($intFloat));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTime', a(new \DateTime()));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', a($mixed));
}
/**
 * @template T of \DateTimeInterface
 * @param T $a
 * @return T
 */
function b($a)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of DateTimeInterface (function PHPStan\\Generics\\FunctionsAssertType\\b(), argument)', $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of DateTimeInterface (function PHPStan\\Generics\\FunctionsAssertType\\b(), argument)', b($a));
    return $a;
}
/**
 * @param \DateTimeInterface $dateTimeInterface
 */
function assertTypeTest($dateTimeInterface)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTime', b(new \DateTime()));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTimeImmutable', b(new \DateTimeImmutable()));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTimeInterface', b($dateTimeInterface));
}
/**
 * @template K
 * @template V
 * @param array<K,V> $a
 * @return array<K,V>
 */
function c($a)
{
    return $a;
}
/**
 * @param array<int, string> $arrayOfString
 */
function testC($arrayOfString)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', c($arrayOfString));
}
/**
 * @template T
 * @param T $a
 * @param T $b
 * @return T
 */
function d($a, $b)
{
    return $a;
}
/**
 * @param int $int
 * @param float $float
 * @param int|float $intFloat
 */
function testD($int, $float, $intFloat)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', d($int, $int));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float|int', d($int, $float));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTime|int', d($int, new \DateTime()));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTime|float|int', d($intFloat, new \DateTime()));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array()|DateTime', d([], new \DateTime()));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'blabla\' => string)|DateTime', d(['blabla' => 'barrrr'], new \DateTime()));
}
/**
 * @template T
 * @param array<\DateTime|array<T>> $a
 * @return T
 */
function e($a)
{
    throw new \Exception();
}
/**
 * @param int $int
 */
function testE($int)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', e([[$int]]));
}
/**
 * @template A
 * @template B
 *
 * @param array<A> $a
 * @param callable(A):B $b
 *
 * @return array<B>
 */
function f($a, $b)
{
    $result = [];
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<A (function PHPStan\\Generics\\FunctionsAssertType\\f(), argument)>', $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('callable(A (function PHPStan\\Generics\\FunctionsAssertType\\f(), argument)): B (function PHPStan\\Generics\\FunctionsAssertType\\f(), argument)', $b);
    foreach ($a as $k => $v) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('A (function PHPStan\\Generics\\FunctionsAssertType\\f(), argument)', $v);
        $newV = $b($v);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('B (function PHPStan\\Generics\\FunctionsAssertType\\f(), argument)', $newV);
        $result[$k] = $newV;
    }
    return $result;
}
/**
 * @param array<int> $arrayOfInt
 * @param null|(callable(int):string) $callableOrNull
 */
function testF($arrayOfInt, $callableOrNull)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string&numeric>', f($arrayOfInt, function (int $a) : string {
        return (string) $a;
    }));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>', f($arrayOfInt, function ($a) : string {
        return (string) $a;
    }));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', f($arrayOfInt, function ($a) {
        return $a;
    }));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>', f($arrayOfInt, $callableOrNull));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', f($arrayOfInt, null));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', f($arrayOfInt, ''));
}
/**
 * @template T
 * @param T $a
 * @return array<T>
 */
function g($a)
{
    return [$a];
}
/**
 * @param int $int
 */
function testG($int)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int>', g($int));
}
class Foo
{
    /** @var static */
    public static $staticProp;
    /** @return static */
    public static function returnsStatic()
    {
        return new static();
    }
    /** @return static */
    public function instanceReturnsStatic()
    {
        return new static();
    }
}
/**
 * @template T of Foo
 * @param T $foo
 */
function testReturnsStatic($foo)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of PHPStan\\Generics\\FunctionsAssertType\\Foo (function PHPStan\\Generics\\FunctionsAssertType\\testReturnsStatic(), argument)', $foo::returnsStatic());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of PHPStan\\Generics\\FunctionsAssertType\\Foo (function PHPStan\\Generics\\FunctionsAssertType\\testReturnsStatic(), argument)', $foo->instanceReturnsStatic());
}
/**
 * @param int[] $listOfIntegers
 */
function testArrayMap(array $listOfIntegers)
{
    $strings = \array_map(function ($int) : string {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $int);
        return (string) $int;
    }, $listOfIntegers);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>', $strings);
}
/**
 * @param int[] $listOfIntegers
 */
function testArrayFilter(array $listOfIntegers)
{
    $integers = \array_filter($listOfIntegers, function ($int) : bool {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $int);
        return \true;
    });
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int>', $integers);
}
/**
 * @template K
 * @template V
 * @param iterable<K, V> $it
 * @return array<K, V>
 */
function iterableToArray($it)
{
    $ret = [];
    foreach ($it as $k => $v) {
        $ret[$k] = $v;
    }
    return $ret;
}
/**
 * @param iterable<string, Foo> $it
 */
function testIterable(iterable $it)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, PHPStan\\Generics\\FunctionsAssertType\\Foo>', iterableToArray($it));
}
/**
 * @template T
 * @template U
 * @param array{a: T, b: U, c: int} $a
 * @return array{T, U}
 */
function constantArray($a) : array
{
    return [$a['a'], $a['b']];
}
function testConstantArray(int $int, string $str)
{
    [$a, $b] = constantArray(['a' => $int, 'b' => $str, 'c' => 1]);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $b);
}
/**
 * @template U of \DateTimeInterface
 * @param U $a
 * @return U
 */
function typeHints(\DateTimeInterface $a) : \DateTimeInterface
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('U of DateTimeInterface (function PHPStan\\Generics\\FunctionsAssertType\\typeHints(), argument)', $a);
    return $a;
}
/**
 * @template U of \DateTime
 * @param U $a
 * @return U
 */
function typeHintsSuperType(\DateTimeInterface $a) : \DateTimeInterface
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('U of DateTime (function PHPStan\\Generics\\FunctionsAssertType\\typeHintsSuperType(), argument)', $a);
    return $a;
}
/**
 * @template U of \DateTimeInterface
 * @param U $a
 * @return U
 */
function typeHintsSubType(\DateTime $a) : \DateTimeInterface
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTime', $a);
    return $a;
}
function testTypeHints() : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTime', typeHints(new \DateTime()));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTime', typeHintsSuperType(new \DateTime()));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTimeInterface', typeHintsSubType(new \DateTime()));
}
/**
 * @template T of \Exception
 * @param T $a
 * @param T $b
 * @return T
 */
function expectsException($a, $b)
{
    return $b;
}
function testUpperBounds(\Throwable $t)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Exception', expectsException(new \Exception(), $t));
}
/**
 * @template T
 * @param callable $cb
 * @return T
 */
function varAnnotation($cb)
{
    /** @var T */
    $v = $cb();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (function PHPStan\\Generics\\FunctionsAssertType\\varAnnotation(), argument)', $v);
    return $v;
}
/**
 * @template T
 */
class C
{
    /** @var T */
    private $a;
    /**
     * @param T $p
     * @param callable $cb
     */
    public function f($p, $cb)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (class PHPStan\\Generics\\FunctionsAssertType\\C, argument)', $p);
        /** @var T */
        $v = $cb();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (class PHPStan\\Generics\\FunctionsAssertType\\C, argument)', $v);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (class PHPStan\\Generics\\FunctionsAssertType\\C, argument)', $this->a);
        $a = new class
        {
            /** @return T */
            public function g()
            {
                throw new \Exception();
            }
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (class PHPStan\\Generics\\FunctionsAssertType\\C, argument)', $a->g());
    }
}
/**
 * @template T
 */
class A
{
    /** @var T */
    private $a;
    /** @var T */
    public $b;
    /**
     * A::__construct()
     *
     * @param T $a
     */
    public function __construct($a)
    {
        $this->a = $a;
        $this->b = $a;
    }
    /**
     * @return T
     */
    public function get()
    {
        asserType('T (class PHPStan\\Generics\\FunctionsAssertType\\A, argument)', $this->a);
        asserType('T (class PHPStan\\Generics\\FunctionsAssertType\\A, argument)', $this->b);
        return $this->a;
    }
    /**
     * @param T $a
     */
    public function set($a)
    {
        $this->a = $a;
    }
}
/**
 * @extends A<\DateTime>
 */
class AOfDateTime extends \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\A
{
    public function __construct()
    {
        parent::__construct(new \DateTime());
    }
}
/**
 * @template T
 *
 * @extends A<T>
 */
class B extends \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\A
{
    /**
     * B::__construct()
     *
     * @param T $a
     */
    public function __construct($a)
    {
        parent::__construct($a);
    }
}
/**
 * @template T
 */
interface I
{
    /**
     * I::get()
     *
     * @return T
     */
    function get();
    /**
     * I::getInheritdoc()
     *
     * @return T
     */
    function getInheritdoc();
}
/**
 * @implements I<int>
 */
class CofI implements \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\I
{
    public function get()
    {
    }
    /** @inheritdoc */
    public function getInheritdoc()
    {
    }
}
/**
 * Interface SuperIfaceA
 *
 * @template A
 */
interface SuperIfaceA
{
    /**
     * SuperIfaceA::get()
     *
     * @param A $a
     * @return A
     */
    public function getA($a);
}
/**
 * Interface SuperIfaceB
 *
 * @template B
 */
interface SuperIfaceB
{
    /**
     * SuperIfaceB::get()
     *
     * @param B $b
     * @return B
     */
    public function getB($b);
}
/**
 * IfaceAB
 *
 * @template T
 *
 * @extends SuperIfaceA<int>
 * @extends SuperIfaceB<T>
 */
interface IfaceAB extends \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\SuperIfaceA, \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\SuperIfaceB
{
}
/**
 * ABImpl
 *
 * @implements IfaceAB<\DateTime>
 */
class ABImpl implements \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\IfaceAB
{
    public function getA($a)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $a);
        return 1;
    }
    public function getB($b)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTime', $b);
        return new \DateTime();
    }
}
/**
 * @implements SuperIfaceA<int>
 */
class X implements \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\SuperIfaceA
{
    public function getA($a)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $a);
        return 1;
    }
}
/**
 * @template T
 *
 * @extends A<T>
 */
class NoConstructor extends \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\A
{
}
/**
 * @template T
 * @param class-string<T> $s
 * @return T
 */
function acceptsClassString(string $s)
{
    return new $s();
}
/**
 * @template U
 * @param class-string<U> $s
 * @return class-string<U>
 */
function anotherAcceptsClassString(string $s)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('U (function PHPStan\\Generics\\FunctionsAssertType\\anotherAcceptsClassString(), argument)', acceptsClassString($s));
}
/**
 * @template T
 * @param T $object
 * @return class-string<T>
 */
function returnsClassString($object)
{
    return \get_class($object);
}
/**
 * @template T of \Exception
 * @param class-string<T> $string
 * @return T
 */
function acceptsClassStringUpperBound($string)
{
    return new $string();
}
/**
 * @template TNodeType of \PhpParser\Node
 */
interface GenericRule
{
    /**
     * @return TNodeType
     */
    public function getNodeInstance() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node;
    /**
     * @return class-string<TNodeType>
     */
    public function getNodeType() : string;
}
/**
 * @implements GenericRule<\PhpParser\Node\Expr\StaticCall>
 */
class SomeRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\GenericRule
{
    public function getNodeInstance() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node
    {
        return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name(\stdClass::class), '__construct');
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall::class;
    }
}
class SomeRule2 implements \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\GenericRule
{
    public function getNodeInstance() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node
    {
        return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name(\stdClass::class), '__construct');
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node::class;
    }
}
/**
 * Infer from generic
 *
 * @template T of \DateTimeInterface
 *
 * @param A<A<T>> $x
 *
 * @return A<T>
 */
function inferFromGeneric($x)
{
    return $x->get();
}
/**
 * @template A
 * @template B
 */
class Factory
{
    private $a;
    private $b;
    /**
     * @param A $a
     * @param B $b
     */
    public function __construct($a, $b)
    {
        $this->a = $a;
        $this->b = $b;
    }
    /**
     * @template C
     * @template D
     *
     * @param A $a
     * @param C $c
     * @param D $d
     *
     * @return array{A, B, C, D}
     */
    public function create($a, $c, $d) : array
    {
        return [$a, $this->b, $c, $d];
    }
}
function testClasses()
{
    $a = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\A(1);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('PHPStan\\Generics\\FunctionsAssertType\\A<int>', $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $a->get());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $a->b);
    $a = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\AOfDateTime();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\AOfDateTime', $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTime', $a->get());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTime', $a->b);
    $b = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\B(1);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('PHPStan\\Generics\\FunctionsAssertType\\B<int>', $b);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $b->get());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $b->b);
    $c = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\CofI();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\CofI', $c);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $c->get());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $c->getInheritdoc());
    $ab = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\ABImpl();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $ab->getA(0));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTime', $ab->getB(new \DateTime()));
    $noConstructor = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\NoConstructor(1);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('PHPStan\\Generics\\FunctionsAssertType\\NoConstructor<mixed>', $noConstructor);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', acceptsClassString(\stdClass::class));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<stdClass>', returnsClassString(new \stdClass()));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Exception', acceptsClassStringUpperBound(\Exception::class));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Exception', acceptsClassStringUpperBound(\Throwable::class));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('InvalidArgumentException', acceptsClassStringUpperBound(\InvalidArgumentException::class));
    $rule = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\SomeRule();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall::class, $rule->getNodeInstance());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<' . \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall::class . '>', $rule->getNodeType());
    $rule2 = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\SomeRule2();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\PhpParser\Node::class, $rule2->getNodeInstance());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<' . \TenantCloud\BetterReflection\Relocated\PhpParser\Node::class . '>', $rule2->getNodeType());
    $a = inferFromGeneric(new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\A(new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\A(new \DateTime())));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('PHPStan\\Generics\\FunctionsAssertType\\A<DateTime>', $a);
    $factory = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\Factory(new \DateTime(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\A(1));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(DateTime, PHPStan\\Generics\\FunctionsAssertType\\A<int>, string, PHPStan\\Generics\\FunctionsAssertType\\A<DateTime>)', $factory->create(new \DateTime(), '', new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\A(new \DateTime())));
}
/**
 * @template T
 */
interface GenericIterator extends \IteratorAggregate
{
    /**
     * @return \Iterator<T>
     */
    public function getIterator() : \Iterator;
}
function () {
    /** @var GenericIterator<int> $iterator */
    $iterator = doFoo();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('PHPStan\\Generics\\FunctionsAssertType\\GenericIterator<int>', $iterator);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Iterator<mixed, int>', $iterator->getIterator());
    foreach ($iterator as $int) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $int);
    }
};
function (\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\GenericRule $rule) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<PhpParser\\Node>', $rule->getNodeType());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\PhpParser\Node::class, $rule->getNodeInstance());
};
/**
 * @template T of \PhpParser\Node
 */
class GenericClassWithProperty
{
    /** @var T */
    public $a;
}
function (\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\GenericClassWithProperty $obj) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\PhpParser\Node::class, $obj->a);
};
class ClassThatExtendsGenericClassWithPropertyWithoutSpecifyingTemplateType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\GenericClassWithProperty
{
}
function (\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\ClassThatExtendsGenericClassWithPropertyWithoutSpecifyingTemplateType $obj) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\PhpParser\Node::class, $obj->a);
};
/**
 * @template T of \DateTimeInterface
 */
class GenericThis
{
    /** @param T $foo */
    public function __construct(\DateTimeInterface $foo)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of DateTimeInterface (class PHPStan\\Generics\\FunctionsAssertType\\GenericThis, argument)', $this->getFoo());
    }
    /** @return T */
    public function getFoo()
    {
    }
}
/**
 * @template T
 */
class Cache
{
    /**
     * @param T $t
     */
    public function __construct($t)
    {
    }
    /**
     * Function Cache::get
     *
     * @return T
     */
    public function get()
    {
    }
}
/**
 * Function cache0
 *
 * @template T
 *
 * @param T $t
 */
function cache0($t) : void
{
    $c = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\Cache($t);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (function PHPStan\\Generics\\FunctionsAssertType\\cache0(), argument)', $c->get());
}
/**
 * Function cache1
 *
 * @template T
 *
 * @param T $t
 */
function cache1($t) : void
{
    $c = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\Cache($t);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (function PHPStan\\Generics\\FunctionsAssertType\\cache1(), argument)', $c->get());
}
function newHandling() : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('PHPStan\\Generics\\FunctionsAssertType\\C<mixed>', new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\C());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('PHPStan\\Generics\\FunctionsAssertType\\A<stdClass>', new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\A(new \stdClass()));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('PHPStan\\Generics\\FunctionsAssertType\\A<mixed>', new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\A());
}
/**
 * @template TKey
 * @template TValue of \stdClass
 */
class StdClassCollection
{
    /** @var array<TKey, TValue> */
    private $list;
    /**
     * @param array<TKey, TValue> $list
     */
    public function __construct(array $list)
    {
    }
    /**
     * @return array<TKey, TValue>
     */
    public function getAll() : array
    {
        return $this->list;
    }
    /**
     * @return static
     */
    public function returnStatic() : self
    {
    }
}
function () {
    $stdEmpty = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\StdClassCollection([]);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('PHPStan\\Generics\\FunctionsAssertType\\StdClassCollection<mixed, stdClass>', $stdEmpty);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<stdClass>', $stdEmpty->getAll());
    $std = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\StdClassCollection([new \stdClass()]);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('PHPStan\\Generics\\FunctionsAssertType\\StdClassCollection<int, stdClass>', $std);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('PHPStan\\Generics\\FunctionsAssertType\\StdClassCollection<int, stdClass>', $std->returnStatic());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, stdClass>', $std->getAll());
};
class ClassWithMethodCachingIssue
{
    /**
     * @template T
     * @param T $a
     */
    public function doFoo($a)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (method PHPStan\\Generics\\FunctionsAssertType\\ClassWithMethodCachingIssue::doFoo(), argument)', $a);
        /** @var T $b */
        $b = doFoo();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (method PHPStan\\Generics\\FunctionsAssertType\\ClassWithMethodCachingIssue::doFoo(), argument)', $b);
    }
    /**
     * @template T
     * @param T $a
     */
    public function doBar($a)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (method PHPStan\\Generics\\FunctionsAssertType\\ClassWithMethodCachingIssue::doBar(), argument)', $a);
        /** @var T $b */
        $b = doFoo();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (method PHPStan\\Generics\\FunctionsAssertType\\ClassWithMethodCachingIssue::doBar(), argument)', $b);
    }
}
/**
 * @param \ReflectionClass<Foo> $ref
 */
function testReflectionClass($ref)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<PHPStan\\Generics\\FunctionsAssertType\\Foo>', $ref->name);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<PHPStan\\Generics\\FunctionsAssertType\\Foo>', $ref->getName());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\Foo', $ref->newInstanceWithoutConstructor());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('ReflectionClass<PHPStan\\Generics\\FunctionsAssertType\\Foo>', new \ReflectionClass(\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\Foo::class));
}
class CreateClassReflectionOfStaticClass
{
    public function doFoo()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\CreateClassReflectionOfStaticClass', (new \ReflectionClass(self::class))->newInstanceWithoutConstructor());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\CreateClassReflectionOfStaticClass', (new \ReflectionClass(static::class))->newInstanceWithoutConstructor());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<PHPStan\\Generics\\FunctionsAssertType\\CreateClassReflectionOfStaticClass>', (new \ReflectionClass(static::class))->name);
    }
}
/**
 * @param \Traversable<int> $t1
 * @param \Traversable<int, \stdClass> $t2
 */
function testIterateOverTraversable($t1, $t2)
{
    foreach ($t1 as $int) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $int);
    }
    foreach ($t2 as $key => $value) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $key);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $value);
    }
}
/**
 * @return \Generator<int, string, \stdClass, \Exception>
 */
function getGenerator() : \Generator
{
    $stdClass = (yield 'foo');
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\stdClass::class, $stdClass);
}
function testYieldFrom()
{
    $yield = (yield from getGenerator());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Exception', $yield);
}
/**
 * @template T
 */
class StaticClassConstant
{
    public function doFoo()
    {
        $staticClassName = static::class;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<static(PHPStan\\Generics\\FunctionsAssertType\\StaticClassConstant)>', $staticClassName);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('static(PHPStan\\Generics\\FunctionsAssertType\\StaticClassConstant)', new $staticClassName());
    }
    /**
     * @param class-string<T> $type
     */
    public function doBar(string $type)
    {
        if ($type !== \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\Foo::class && $type !== \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\C::class) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<T (class PHPStan\\Generics\\FunctionsAssertType\\StaticClassConstant, argument)>', $type);
            throw new \InvalidArgumentException();
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'PHPStan\\\\Generics\\\\FunctionsAssertType\\\\C\'|\'PHPStan\\\\Generics\\\\FunctionsAssertType\\\\Foo\'', $type);
    }
}
/**
 * @template T of \DateTime
 * @template U as \DateTime
 * @param T $a
 * @param U $b
 */
function testBounds($a, $b) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of DateTime (function PHPStan\\Generics\\FunctionsAssertType\\testBounds(), argument)', $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('U of DateTime (function PHPStan\\Generics\\FunctionsAssertType\\testBounds(), argument)', $b);
}
/**
 * @template T of object
 * @param T $a
 * @return T
 */
function testGenericObjectWithoutClassType($a)
{
    return $a;
}
/**
 * @template T of object
 * @param T $a
 * @return T
 */
function testGenericObjectWithoutClassType2($a)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of object (function PHPStan\\Generics\\FunctionsAssertType\\testGenericObjectWithoutClassType2(), argument)', $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of object (function PHPStan\\Generics\\FunctionsAssertType\\testGenericObjectWithoutClassType2(), argument)', testGenericObjectWithoutClassType($a));
    $b = $a;
    if ($b instanceof \stdClass) {
        return $a;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of object (function PHPStan\\Generics\\FunctionsAssertType\\testGenericObjectWithoutClassType2(), argument)', $b);
    return $a;
}
function () {
    $a = new \stdClass();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', testGenericObjectWithoutClassType($a));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', testGenericObjectWithoutClassType(testGenericObjectWithoutClassType($a)));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', testGenericObjectWithoutClassType2(testGenericObjectWithoutClassType($a)));
};
/**
 * @template T of object
 * @extends \ReflectionClass<T>
 */
class GenericReflectionClass extends \ReflectionClass
{
    public function newInstanceWithoutConstructor()
    {
        return parent::newInstanceWithoutConstructor();
    }
}
/**
 * @extends \ReflectionClass<\stdClass>
 */
class SpecificReflectionClass extends \ReflectionClass
{
    public function newInstanceWithoutConstructor()
    {
        return parent::newInstanceWithoutConstructor();
    }
}
/**
 * @param GenericReflectionClass<\stdClass> $ref
 */
function testGenericReflectionClass($ref)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<stdClass>', $ref->name);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $ref->newInstanceWithoutConstructor());
}
/**
 * @param SpecificReflectionClass $ref
 */
function testSpecificReflectionClass($ref)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<stdClass>', $ref->name);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $ref->newInstanceWithoutConstructor());
}
/**
 * @template T of Foo
 * @phpstan-template T of Bar
 */
class PrefixedTemplateWins
{
    /** @var T */
    public $name;
}
/**
 * @phpstan-template T of Bar
 * @template T of Foo
 */
class PrefixedTemplateWins2
{
    /** @var T */
    public $name;
}
/**
 * @template T of Foo
 * @phpstan-template T of Bar
 * @psalm-template T of Baz
 */
class PrefixedTemplateWins3
{
    /** @var T */
    public $name;
}
/**
 * @template T of Foo
 * @psalm-template T of Bar
 */
class PrefixedTemplateWins4
{
    /** @var T */
    public $name;
}
/**
 * @psalm-template T of Foo
 * @phpstan-template T of Bar
 */
class PrefixedTemplateWins5
{
    /** @var T */
    public $name;
}
function testPrefixed(\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\PrefixedTemplateWins $a, \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\PrefixedTemplateWins2 $b, \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\PrefixedTemplateWins3 $c, \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\PrefixedTemplateWins4 $d, \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\PrefixedTemplateWins5 $e)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\Bar', $a->name);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\Bar', $b->name);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\Bar', $c->name);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\Bar', $d->name);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\Bar', $e->name);
}
/**
 * @template T of object
 * @param class-string<T> $classString
 * @return T
 */
function acceptsClassStringOfObject(string $classString)
{
}
/**
 * @param class-string $classString
 */
function testClassString(string $classString)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string', $classString);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', acceptsClassString($classString));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Exception', acceptsClassStringUpperBound($classString));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', acceptsClassStringOfObject($classString));
}
class Bar extends \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\Foo
{
}
/**
 * @template T of Foo
 * @param class-string<T> $classString
 * @param class-string<Foo> $anotherClassString
 * @param class-string<Bar> $yetAnotherClassString
 */
function returnStaticOnClassString(string $classString, string $anotherClassString, string $yetAnotherClassString)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of PHPStan\\Generics\\FunctionsAssertType\\Foo (function PHPStan\\Generics\\FunctionsAssertType\\returnStaticOnClassString(), argument)', $classString::returnsStatic());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of PHPStan\\Generics\\FunctionsAssertType\\Foo (function PHPStan\\Generics\\FunctionsAssertType\\returnStaticOnClassString(), argument)', $classString::instanceReturnsStatic());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of PHPStan\\Generics\\FunctionsAssertType\\Foo (function PHPStan\\Generics\\FunctionsAssertType\\returnStaticOnClassString(), argument)', $classString::$staticProp);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\Foo', $anotherClassString::instanceReturnsStatic());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\Foo', $anotherClassString::returnsStatic());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\Foo', $anotherClassString::$staticProp);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\Bar', $yetAnotherClassString::instanceReturnsStatic());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\Bar', $yetAnotherClassString::returnsStatic());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Generics\\FunctionsAssertType\\Bar', $yetAnotherClassString::$staticProp);
}
/**
 * @param class-string<Foo>[] $a
 */
function arrayOfGenericClassStrings(array $a) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<class-string<PHPStan\\Generics\\FunctionsAssertType\\Foo>>', $a);
}
/**
 * @template T
 * @template U of \Exception
 * @template V of \DateTimeInterface
 * @template W of object
 * @param T $a
 * @param U $b
 * @param U|V $c
 * @param \Iterator<\DateTimeInterface> $d
 * @param object $object
 * @param mixed $mixed
 * @param W $tObject
 */
function getClassOnTemplateType($a, $b, $c, $d, $object, $mixed, $tObject)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<T (function PHPStan\\Generics\\FunctionsAssertType\\getClassOnTemplateType(), argument)>', \get_class($a));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<U of Exception (function PHPStan\\Generics\\FunctionsAssertType\\getClassOnTemplateType(), argument)>', \get_class($b));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<U of Exception (function PHPStan\\Generics\\FunctionsAssertType\\getClassOnTemplateType(), argument)>|' . 'class-string<V of DateTimeInterface (function PHPStan\\Generics\\FunctionsAssertType\\getClassOnTemplateType(), argument)>', \get_class($c));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<Iterator<mixed, DateTimeInterface>>', \get_class($d));
    $objectB = new $b();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('U of Exception (function PHPStan\\Generics\\FunctionsAssertType\\getClassOnTemplateType(), argument)', $objectB);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<U of Exception (function PHPStan\\Generics\\FunctionsAssertType\\getClassOnTemplateType(), argument)>', \get_class($objectB));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string', \get_class($object));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string', \get_class($mixed));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<W of object (function PHPStan\\Generics\\FunctionsAssertType\\getClassOnTemplateType(), argument)>', \get_class($tObject));
}
/**
 * @template T
 */
class TagMergingGrandparent
{
    /** @var T */
    public $property;
    /**
     * @param T $one
     * @param int $two
     */
    public function method($one, $two) : void
    {
    }
}
/**
 * @template TT
 * @extends TagMergingGrandparent<TT>
 */
class TagMergingParent extends \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\TagMergingGrandparent
{
    /**
     * @param TT $one
     */
    public function method($one, $two) : void
    {
    }
}
/**
 * @extends TagMergingParent<float>
 */
class TagMergingChild extends \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\TagMergingParent
{
    public function method($one, $two) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $one);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $two);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $this->property);
    }
}
/**
 * @template T
 */
interface GeneralFactoryInterface
{
    /**
     * @return T
     */
    public static function create();
}
class Car
{
}
/**
 * @implements GeneralFactoryInterface<Car>
 */
class CarFactory implements \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\GeneralFactoryInterface
{
    public static function create()
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\Car();
    }
}
class CarFactoryProcessor
{
    /**
     * @param class-string<CarFactory> $class
     */
    public function process($class) : void
    {
        $car = $class::create();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\PHPStan\Generics\FunctionsAssertType\Car::class, $car);
    }
}
function (\Throwable $e) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $e->getCode());
};
function () : void {
    $array = ['a' => 1, 'b' => 2];
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'a\' => int, \'b\' => int)', a($array));
};
