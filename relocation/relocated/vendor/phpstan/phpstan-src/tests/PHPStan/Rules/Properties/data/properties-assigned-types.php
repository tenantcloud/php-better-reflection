<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PropertiesAssignedTypes;

class Foo extends \TenantCloud\BetterReflection\Relocated\PropertiesAssignedTypes\Ipsum
{
    /** @var string */
    private $stringProperty;
    /** @var int */
    private $intProperty;
    /** @var self */
    private $fooProperty;
    /** @var string */
    private static $staticStringProperty;
    /** @var self[]|Collection|array */
    private $unionPropertySelf;
    /** @var Bar[]|self */
    private $unionPropertyBar;
    public function doFoo()
    {
        $this->stringProperty = 'foo';
        $this->stringProperty = 1;
        $this->intProperty = 1;
        $this->intProperty = 'foo';
        $this->fooProperty = new self();
        $this->fooProperty = new \TenantCloud\BetterReflection\Relocated\PropertiesAssignedTypes\Bar();
        self::$staticStringProperty = 'foo';
        self::$staticStringProperty = 1;
        \TenantCloud\BetterReflection\Relocated\PropertiesAssignedTypes\Foo::$staticStringProperty = 'foo';
        \TenantCloud\BetterReflection\Relocated\PropertiesAssignedTypes\Foo::$staticStringProperty = 1;
        parent::$parentStringProperty = 'foo';
        parent::$parentStringProperty = 1;
        $this->nonexistentProperty = 'foo';
        $this->nonexistentProperty = 1;
        $this->unionPropertySelf = [new self()];
        $this->unionPropertySelf = new \TenantCloud\BetterReflection\Relocated\PropertiesAssignedTypes\Collection();
        $this->unionPropertySelf = new self();
        $this->unionPropertySelf = [new \TenantCloud\BetterReflection\Relocated\PropertiesAssignedTypes\Bar()];
        $this->unionPropertySelf = new \TenantCloud\BetterReflection\Relocated\PropertiesAssignedTypes\Bar();
        $this->parentStringProperty = 'foo';
        $this->parentStringProperty = 1;
        self::$parentStaticStringProperty = 'foo';
        self::$parentStaticStringProperty = 1;
        if ($this->intProperty === null) {
            $this->intProperty = 1;
        }
    }
    public function doBar()
    {
        $this->intProperty += 1;
        // OK
        $this->intProperty .= 'test';
        // property will be string, report error
    }
}
class Ipsum
{
    /** @var string */
    protected $parentStringProperty;
    /** @var string */
    protected static $parentStaticStringProperty;
    /** @var int|null */
    private $nullableIntProperty;
    /** @var mixed[]*/
    private $mixedArrayProperty;
    /** @var mixed[]|iterable */
    private $iterableProperty;
    /** @var iterable */
    private $iterableData;
    /** @var Ipsum */
    private $foo;
    /** @var Ipsum */
    private static $fooStatic;
    public function doIpsum()
    {
        if ($this->nullableIntProperty === null) {
            return;
        }
        $this->nullableIntProperty = null;
    }
    /**
     * @param mixed[]|string $scope
     */
    public function setScope($scope)
    {
        if (!\is_array($scope)) {
            $this->mixedArrayProperty = \explode(',', $scope);
        } else {
            $this->mixedArrayProperty = $scope;
        }
    }
    /**
     * @param int[]|iterable $integers
     * @param string[]|iterable $strings
     * @param mixed[]|iterable $mixeds
     * @param iterable $justIterableInPhpDoc
     * @param iterable $justIterableInPhpDocWithCheck
     */
    public function setIterable(iterable $integers, iterable $strings, iterable $mixeds, $justIterableInPhpDoc, $justIterableInPhpDocWithCheck)
    {
        $this->iterableProperty = $integers;
        $this->iterableProperty = $strings;
        $this->iterableProperty = $mixeds;
        $this->iterableData = $justIterableInPhpDoc;
        if (!\is_iterable($justIterableInPhpDocWithCheck)) {
            throw new \Exception();
        }
        $this->iterableData = $justIterableInPhpDocWithCheck;
    }
    public function doIntersection()
    {
        if ($this->foo instanceof \TenantCloud\BetterReflection\Relocated\PropertiesAssignedTypes\SomeInterface) {
            $this->foo->foo = new \TenantCloud\BetterReflection\Relocated\PropertiesAssignedTypes\Bar();
            self::$fooStatic::$fooStatic = new \TenantCloud\BetterReflection\Relocated\PropertiesAssignedTypes\Bar();
        }
    }
}
interface SomeInterface
{
}
class Collection implements \IteratorAggregate
{
    public function getIterator()
    {
        return new \ArrayIterator([]);
    }
}
class SimpleXMLElementAccepts
{
    public function doFoo(\SimpleXMLElement $xml)
    {
        $xml->foo = 'foo';
        $xml->bar = 1.234;
        $xml->baz = \true;
        $xml->lorem = \false;
        $xml->ipsum = 1024;
        $xml->test = $xml;
        $this->takeSimpleXmlElement($xml->foo);
        $this->takeSimpleXmlElement($xml->bar);
        $this->takeSimpleXmlElement($xml->baz);
        $this->takeSimpleXmlElement($xml->lorem);
        $this->takeSimpleXmlElement($xml->ipsum);
        $this->takeSimpleXmlElement($xml->test);
    }
    public function takeSimpleXmlElement(\SimpleXMLElement $_)
    {
    }
}
class MultipleCallableItems
{
    /** @var callable[] */
    private $rules = [];
    public function __construct()
    {
        $this->rules = [[$this, 'doSomething'], [$this, 'somethingElse']];
    }
    private function doSomething()
    {
    }
    private function somethingElse()
    {
    }
}
class ConcreteIterableAcceptsMixedIterable
{
    /**
     * @var Foo[]
     */
    private $array;
    /**
     * @var \Traversable<Foo>
     */
    private $traversable;
    /**
     * @var iterable<Foo>
     */
    private $iterable;
    public function __construct(array $array, \Traversable $traversable, iterable $iterable)
    {
        $this->array = $array;
        $this->traversable = $traversable;
        $this->iterable = $iterable;
    }
}
/**
 * @template T
 */
class GenericClass
{
    /**
     * @param T $type
     */
    public function __construct($type)
    {
    }
}
class ClassWithPropertyThatAcceptsGenericClass
{
    /** @var GenericClass<Foo> */
    private $genericProp;
    /** @var GenericClass<mixed> */
    private $genericProp2;
    /**
     * @param GenericClass<mixed> $a
     */
    public function doFoo($a)
    {
        $this->genericProp = $a;
    }
    /**
     * @param GenericClass<Foo> $a
     */
    public function doBar($a)
    {
        $this->genericProp2 = $a;
    }
}
/**
 * @template T
 */
class Baz
{
    /** @var array{array<T>} */
    private $var;
    function test() : void
    {
        $this->var = [[]];
    }
}
class AssignRefFoo
{
    /** @var string */
    private $stringProperty;
    public function doFoo()
    {
        $i = 1;
        $this->stringProperty =& $i;
    }
}
