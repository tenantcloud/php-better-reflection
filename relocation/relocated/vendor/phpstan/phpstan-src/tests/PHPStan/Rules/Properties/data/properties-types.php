<?php

namespace TenantCloud\BetterReflection\Relocated\PropertiesTypes;

class Foo
{
    /** @var Foo */
    private $foo;
    /** @var Bar */
    private $bar;
    /** @var Foo[] */
    private $foos;
    /** @var Bar[] */
    private $bars;
    /** @var Ipsum|Dolor[] */
    private $dolors;
    /** @var FOO|Fooo|BAR */
    private $fooWithWrongCase;
    /** @var SomeTrait */
    private $withTrait;
    /** @var \Datetime */
    private $datetime;
    /** @var \InvalidPhpDocDefinitions\FooGeneric<Foooo, Barrrr> */
    private $nonexistentClassInGenericObjectType;
}
trait SomeTrait
{
}
