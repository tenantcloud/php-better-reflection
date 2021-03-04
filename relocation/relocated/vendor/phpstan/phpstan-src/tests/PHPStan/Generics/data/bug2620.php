<?php

namespace TenantCloud\BetterReflection\Relocated\Generics\Bug2620;

class Foo
{
    public function someMethod() : void
    {
    }
}
class Bar
{
}
/**
 * @implements \IteratorAggregate<int, Foo>
 */
class SomeIterator implements \IteratorAggregate
{
    /**
     * @return \Traversable<int, Bar>
     */
    public function getIterator()
    {
        (yield new \TenantCloud\BetterReflection\Relocated\Generics\Bug2620\Bar());
    }
}
/**
 * @param \IteratorAggregate<int, Foo> $i
 */
function takesIteratorAggregate(\IteratorAggregate $i) : void
{
    foreach ($i as $foo) {
        $foo->someMethod();
    }
}
function test() : void
{
    takesIteratorAggregate(new \TenantCloud\BetterReflection\Relocated\Generics\Bug2620\SomeIterator());
}
