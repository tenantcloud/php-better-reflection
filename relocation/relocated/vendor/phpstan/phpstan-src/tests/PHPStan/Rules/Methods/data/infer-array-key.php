<?php

namespace TenantCloud\BetterReflection\Relocated\InferArrayKey;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @implements \IteratorAggregate<int, \stdClass>
 */
class Foo implements \IteratorAggregate
{
    /** @var \stdClass[] */
    private $items;
    public function getIterator()
    {
        $it = new \ArrayIterator($this->items);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(int|string)', $it->key());
        return $it;
    }
}
