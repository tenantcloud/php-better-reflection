<?php

namespace TenantCloud\BetterReflection\Relocated\StubsIntegrationTest;

class Foo
{
    public function doFoo($i)
    {
        return '';
    }
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\Foo $foo) {
    $string = $foo->doFoo('test');
    $foo->doFoo($string);
};
class FooChild extends \TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\Foo
{
    public function doFoo($i)
    {
        return '';
    }
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\FooChild $fooChild) {
    $string = $fooChild->doFoo('test');
    $fooChild->doFoo($string);
};
interface InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo();
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\InterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
interface InterfaceExtendingInterfaceWithStubPhpDoc extends \TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\InterfaceExtendingInterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
interface AnotherInterfaceExtendingInterfaceWithStubPhpDoc extends \TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo();
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\AnotherInterfaceExtendingInterfaceWithStubPhpDoc $stub) : int {
    return $stub->doFoo();
    // implementation wins - string -> int mismatch reported
};
class ClassExtendingInterfaceWithStubPhpDoc implements \TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\ClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
class AnotherClassExtendingInterfaceWithStubPhpDoc implements \TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\AnotherClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
/** This one is missing in the stubs */
class YetAnotherClassExtendingInterfaceWithStubPhpDoc implements \TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\YetAnotherClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    return $stub->doFoo();
    // implementation wins - string -> int mismatch reported
};
class YetYetAnotherClassExtendingInterfaceWithStubPhpDoc implements \TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\YetYetAnotherClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    // return int should be inherited
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
interface InterfaceWithStubPhpDoc2
{
    public function doFoo();
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\InterfaceWithStubPhpDoc2 $stub) : int {
    // return int should be inherited
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
class YetYetAnotherClassExtendingInterfaceWithStubPhpDoc2 implements \TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\InterfaceWithStubPhpDoc2
{
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\YetYetAnotherClassExtendingInterfaceWithStubPhpDoc2 $stub) : int {
    // return int should be inherited
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
class AnotherFooChild extends \TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\Foo
{
    public function doFoo($j)
    {
        return '';
    }
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\AnotherFooChild $foo) : void {
    $string = $foo->doFoo('test');
    $foo->doFoo($string);
};
class YetAnotherFoo
{
    public function doFoo($j)
    {
        return '';
    }
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\YetAnotherFoo $foo) : void {
    $string = $foo->doFoo('test');
    $foo->doFoo($string);
};
class YetYetAnotherFoo
{
    /**
     * Deliberately wrong phpDoc
     * @param \stdClass $j
     * @return \stdClass
     */
    public function doFoo($j)
    {
        return '';
    }
}
function (\TenantCloud\BetterReflection\Relocated\StubsIntegrationTest\YetYetAnotherFoo $foo) : void {
    $string = $foo->doFoo('test');
    $foo->doFoo($string);
};
