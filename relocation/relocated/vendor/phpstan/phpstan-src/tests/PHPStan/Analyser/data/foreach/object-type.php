<?php

namespace TenantCloud\BetterReflection\Relocated\ObjectType;

interface MyKey
{
}
interface MyValue
{
}
interface MyIterator extends \Iterator
{
    public function key() : \TenantCloud\BetterReflection\Relocated\ObjectType\MyKey;
    public function current() : \TenantCloud\BetterReflection\Relocated\ObjectType\MyValue;
}
interface MyIteratorAggregate extends \IteratorAggregate
{
    public function getIterator() : \TenantCloud\BetterReflection\Relocated\ObjectType\MyIterator;
}
interface MyIteratorAggregateRecursive extends \IteratorAggregate
{
    public function getIterator() : \TenantCloud\BetterReflection\Relocated\ObjectType\MyIteratorAggregateRecursive;
}
function test(\TenantCloud\BetterReflection\Relocated\ObjectType\MyIterator $iterator, \TenantCloud\BetterReflection\Relocated\ObjectType\MyIteratorAggregate $iteratorAggregate, \TenantCloud\BetterReflection\Relocated\ObjectType\MyIteratorAggregateRecursive $iteratorAggregateRecursive)
{
    foreach ($iterator as $keyFromIterator => $valueFromIterator) {
        'insideFirstForeach';
    }
    foreach ($iteratorAggregate as $keyFromAggregate => $valueFromAggregate) {
        'insideSecondForeach';
    }
    foreach ($iteratorAggregateRecursive as $keyFromRecursiveAggregate => $valueFromRecursiveAggregate) {
        'insideThirdForeach';
    }
}
