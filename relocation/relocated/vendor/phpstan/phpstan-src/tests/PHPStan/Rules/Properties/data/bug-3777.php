<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3777;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class HelloWorld
{
    /**
     * @var \SplObjectStorage<\DateTimeImmutable, null>
     */
    public $dates;
    public function __construct()
    {
        $this->dates = new \SplObjectStorage();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('SplObjectStorage<DateTimeImmutable, null>', $this->dates);
    }
}
/** @template T of object */
class Foo
{
    public function __construct()
    {
    }
}
/** @template T of object */
class Fooo
{
}
class Bar
{
    /** @var Foo<\stdClass> */
    private $foo;
    /** @var Fooo<\stdClass> */
    private $fooo;
    public function __construct()
    {
        $this->foo = new \TenantCloud\BetterReflection\Relocated\Bug3777\Foo();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug3777\\Foo<stdClass>', $this->foo);
        $this->fooo = new \TenantCloud\BetterReflection\Relocated\Bug3777\Fooo();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug3777\\Fooo<stdClass>', $this->fooo);
    }
    public function doBar()
    {
        $this->foo = new \TenantCloud\BetterReflection\Relocated\Bug3777\Fooo();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug3777\\Fooo<object>', $this->foo);
    }
}
/**
 * @template T of object
 * @template U of object
 */
class Lorem
{
    /**
     * @param T $t
     * @param U $u
     */
    public function __construct($t, $u)
    {
    }
}
class Ipsum
{
    /** @var Lorem<\stdClass, \Exception> */
    private $lorem;
    /** @var Lorem<\stdClass, \Exception> */
    private $ipsum;
    public function __construct()
    {
        $this->lorem = new \TenantCloud\BetterReflection\Relocated\Bug3777\Lorem(new \stdClass(), new \Exception());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug3777\\Lorem<stdClass, Exception>', $this->lorem);
        $this->ipsum = new \TenantCloud\BetterReflection\Relocated\Bug3777\Lorem(new \Exception(), new \stdClass());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug3777\\Lorem<Exception, stdClass>', $this->ipsum);
    }
}
/**
 * @template T of object
 * @template U of object
 */
class Lorem2
{
    /**
     * @param T $t
     */
    public function __construct($t)
    {
    }
}
class Ipsum2
{
    /** @var Lorem2<\stdClass, \Exception> */
    private $lorem2;
    /** @var Lorem2<\stdClass, \Exception> */
    private $ipsum2;
    public function __construct()
    {
        $this->lorem2 = new \TenantCloud\BetterReflection\Relocated\Bug3777\Lorem2(new \stdClass());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug3777\\Lorem2<stdClass, object>', $this->lorem2);
        $this->ipsum2 = new \TenantCloud\BetterReflection\Relocated\Bug3777\Lorem2(new \Exception());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug3777\\Lorem2<Exception, object>', $this->ipsum2);
    }
}
/**
 * @template T of object
 * @template U of object
 */
class Lorem3
{
    /**
     * @param T $t
     * @param U $u
     */
    public function __construct($t, $u)
    {
    }
}
class Ipsum3
{
    /** @var Lorem3<\stdClass, \Exception> */
    private $lorem3;
    /** @var Lorem3<\stdClass, \Exception> */
    private $ipsum3;
    public function __construct()
    {
        $this->lorem3 = new \TenantCloud\BetterReflection\Relocated\Bug3777\Lorem3(new \stdClass(), new \Exception());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug3777\\Lorem3<stdClass, Exception>', $this->lorem3);
        $this->ipsum3 = new \TenantCloud\BetterReflection\Relocated\Bug3777\Lorem3(new \Exception(), new \stdClass());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug3777\\Lorem3<Exception, stdClass>', $this->ipsum3);
    }
}
