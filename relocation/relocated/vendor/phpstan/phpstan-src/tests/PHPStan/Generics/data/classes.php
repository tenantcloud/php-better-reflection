<?php

namespace TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError;
/**
 * class A
 *
 * @template T
 */
class A
{
    /** @var T */
    private $a;
    /** @var T */
    public $b;
    /** @param T $a */
    public function __construct($a)
    {
        $this->a = $a;
        $this->b = $a;
    }
    /**
     * @return T
     */
    public function get(int $i)
    {
        if ($i === 0) {
            return 1;
        }
        return $this->a;
    }
    /**
     * @param T $a
     */
    public function set($a) : void
    {
        $this->a = $a;
    }
}
/**
 * @extends A<\DateTime>
 */
class AOfDateTime extends \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes\A
{
    public function __construct()
    {
        parent::__construct(new \DateTime());
    }
}
/**
 * class B
 *
 * @template T
 *
 * @extends A<T>
 */
class B extends \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes\A
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
     * I::set()
     *
     * @param T $a
     */
    function set($a) : void;
    /**
     * I::get()
     *
     * @return T
     */
    function get();
}
/**
 * Class C
 *
 * @implements I<int>
 */
class C implements \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes\I
{
    /** @var int */
    private $a;
    public function set($a) : void
    {
        $this->a = $a;
    }
    public function get()
    {
        return $this->a;
    }
}
/**
 * Interface SuperIfaceA
 *
 * @template T
 */
interface SuperIfaceA
{
    /**
     * SuperIfaceA::get()
     *
     * @return T
     */
    public function getA();
}
/**
 * Interface SuperIfaceB
 *
 * @template T
 */
interface SuperIfaceB
{
    /**
     * SuperIfaceB::get()
     *
     * @return T
     */
    public function getB();
}
/**
 * IfaceAB
 *
 * @template T
 *
 * @extends SuperIfaceA<int>
 * @extends SuperIfaceB<T>
 */
interface IfaceAB extends \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes\SuperIfaceA, \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes\SuperIfaceB
{
}
/**
 * ABImpl
 *
 * @implements IfaceAB<\DateTime>
 */
class ABImpl implements \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes\IfaceAB
{
    public function getA()
    {
        throw new \Exception();
    }
    public function getB()
    {
        throw new \Exception();
    }
}
/**
 * @param A<\DateTimeInterface> $a
 */
function acceptAofDateTimeInterface($a) : void
{
}
/**
 * @param SuperIfaceA<int> $a
 */
function acceptSuperIFaceAOfInt($a) : void
{
}
/**
 * @param SuperIfaceB<\DateTime> $a
 */
function acceptSuperIFaceBOfDateTime($a) : void
{
}
/**
 * @param SuperIfaceB<int> $a
 */
function acceptSuperIFaceBOfInt($a) : void
{
}
/**
 * @template TNodeType of \PhpParser\Node
 */
interface GenericRule
{
    /**
     * @return class-string<TNodeType>
     */
    public function getNodeType() : string;
    /**
     * @return TNodeType
     */
    public function getNodeInstance() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node;
    /**
     * @param TNodeType $node
     * @param \PHPStan\Analyser\Scope $scope
     * @return RuleError[] errors
     */
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array;
}
/**
 * @implements GenericRule<\PhpParser\Node\Expr\StaticCall>
 */
class SomeRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes\GenericRule
{
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall::class;
    }
    public function getNodeInstance() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node
    {
        return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name(\stdClass::class), '__construct');
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        return [];
    }
}
/**
 * Class GenericThis
 *
 * @template T of \DateTimeInterface
 */
class GenericThis
{
    /** @param T $foo */
    public function __construct(\DateTimeInterface $foo)
    {
        $this->setFoo($foo);
    }
    /** @param T $foo */
    public function setFoo(\DateTimeInterface $foo) : void
    {
    }
}
function testClasses() : void
{
    $a = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes\A(1);
    $a->set(2);
    $a->set($a->get(0));
    $a->set('');
    $a = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes\AOfDateTime();
    $a->set(new \DateTime());
    $a->set($a->get(0));
    $a->set(1);
    $b = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes\B(1);
    $b->set(2);
    $b->set($b->get(0));
    $b->set('');
    $c = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes\C();
    $c->set(2);
    $c->set($c->get());
    $c->set('');
    $ab = new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes\ABImpl();
    acceptSuperIFaceAOfInt($ab);
    acceptSuperIFaceBOfDateTime($ab);
    acceptSuperIFaceBOfInt($ab);
    new \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\Classes\SomeRule();
}
