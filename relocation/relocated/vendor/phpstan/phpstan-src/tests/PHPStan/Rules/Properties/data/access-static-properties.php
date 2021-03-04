<?php

namespace TenantCloud\BetterReflection\Relocated;

// lint < 8.0
class FooAccessStaticProperties
{
    public static $test;
    protected static $foo;
    public $loremIpsum;
}
class BarAccessStaticProperties extends \TenantCloud\BetterReflection\Relocated\FooAccessStaticProperties
{
    public static function test()
    {
        \TenantCloud\BetterReflection\Relocated\FooAccessStaticProperties::$test;
        \TenantCloud\BetterReflection\Relocated\FooAccessStaticProperties::$foo;
        parent::$test;
        parent::$foo;
        \TenantCloud\BetterReflection\Relocated\FooAccessStaticProperties::$bar;
        // nonexistent
        self::$bar;
        // nonexistent
        parent::$bar;
        // nonexistent
        \TenantCloud\BetterReflection\Relocated\FooAccessStaticProperties::$loremIpsum;
        // instance
        static::$foo;
    }
    public function loremIpsum()
    {
        parent::$loremIpsum;
    }
}
class IpsumAccessStaticProperties
{
    public static function ipsum()
    {
        parent::$lorem;
        // does not have a parent
        \TenantCloud\BetterReflection\Relocated\FooAccessStaticProperties::$test;
        \TenantCloud\BetterReflection\Relocated\FooAccessStaticProperties::$foo;
        // protected and not from a parent
        \TenantCloud\BetterReflection\Relocated\FooAccessStaticProperties::${$foo};
        $class::$property;
        \TenantCloud\BetterReflection\Relocated\UnknownStaticProperties::$test;
        if (isset(static::$baz)) {
            static::$baz;
        }
        isset(static::$baz);
        static::$baz;
        if (!isset(static::$nonexistent)) {
            static::$nonexistent;
            return;
        }
        static::$nonexistent;
        if (!empty(static::$emptyBaz)) {
            static::$emptyBaz;
        }
        static::$emptyBaz;
        if (empty(static::$emptyNonexistent)) {
            static::$emptyNonexistent;
            return;
        }
        static::$emptyNonexistent;
        isset(static::$anotherNonexistent) ? static::$anotherNonexistent : null;
        isset(static::$anotherNonexistent) ? null : static::$anotherNonexistent;
        !isset(static::$anotherNonexistent) ? static::$anotherNonexistent : null;
        !isset(static::$anotherNonexistent) ? null : static::$anotherNonexistent;
        empty(static::$anotherEmptyNonexistent) ? static::$anotherEmptyNonexistent : null;
        empty(static::$anotherEmptyNonexistent) ? null : static::$anotherEmptyNonexistent;
        !empty(static::$anotherEmptyNonexistent) ? static::$anotherEmptyNonexistent : null;
        !empty(static::$anotherEmptyNonexistent) ? null : static::$anotherEmptyNonexistent;
    }
}
function () {
    self::$staticFooProperty;
    static::$staticFooProperty;
    parent::$staticFooProperty;
    \TenantCloud\BetterReflection\Relocated\FooAccessStaticProperties::$test;
    \TenantCloud\BetterReflection\Relocated\FooAccessStaticProperties::$foo;
    \TenantCloud\BetterReflection\Relocated\FooAccessStaticProperties::$loremIpsum;
    $foo = new \TenantCloud\BetterReflection\Relocated\FooAccessStaticProperties();
    $foo::$test;
    $foo::$nonexistent;
    $bar = new \TenantCloud\BetterReflection\Relocated\NonexistentClass();
    $bar::$test;
};
interface SomeInterface
{
}
function (\TenantCloud\BetterReflection\Relocated\FooAccessStaticProperties $foo) {
    if ($foo instanceof \TenantCloud\BetterReflection\Relocated\SomeInterface) {
        $foo::$test;
        $foo::$nonexistent;
    }
    /** @var string|int $stringOrInt */
    $stringOrInt = \TenantCloud\BetterReflection\Relocated\doFoo();
    $stringOrInt::$foo;
};
function (\TenantCloud\BetterReflection\Relocated\FOOAccessStaticPropertieS $foo) {
    $foo::$test;
    // do not report case mismatch
    \TenantCloud\BetterReflection\Relocated\FOOAccessStaticPropertieS::$unknownProperties;
    \TenantCloud\BetterReflection\Relocated\FOOAccessStaticPropertieS::$loremIpsum;
    \TenantCloud\BetterReflection\Relocated\FOOAccessStaticPropertieS::$foo;
    \TenantCloud\BetterReflection\Relocated\FOOAccessStaticPropertieS::$test;
};
function (string $className) {
    $className::$fooProperty;
};
class ClassOrString
{
    private static $accessedProperty;
    private $instanceProperty;
    public function doFoo()
    {
        /** @var self|string $class */
        $class = \TenantCloud\BetterReflection\Relocated\doFoo();
        $class::$accessedProperty;
        $class::$unknownProperty;
        \TenantCloud\BetterReflection\Relocated\Self::$accessedProperty;
    }
    public function doBar()
    {
        /** @var self|false $class */
        $class = \TenantCloud\BetterReflection\Relocated\doFoo();
        if (isset($class::$anotherProperty)) {
            echo $class::$anotherProperty;
            echo $class::$instanceProperty;
        }
    }
}
class AccessPropertyWithDimFetch
{
    public function doFoo()
    {
        self::$foo['foo'] = 'test';
    }
    public function doBar()
    {
        self::$foo = 'test';
        // reported by a separate rule
    }
}
class AccessInIsset
{
    public function doFoo()
    {
        if (isset(self::$foo)) {
        }
    }
    public function doBar()
    {
        if (isset(self::$foo['foo'])) {
        }
    }
}
trait TraitWithStaticProperty
{
    public static $foo;
}
class MethodAccessingTraitProperty
{
    public function doFoo() : void
    {
        echo \TenantCloud\BetterReflection\Relocated\TraitWithStaticProperty::$foo;
    }
    public function doBar(\TenantCloud\BetterReflection\Relocated\TraitWithStaticProperty $a) : void
    {
        echo $a::$foo;
    }
}
