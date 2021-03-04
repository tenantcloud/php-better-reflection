<?php

namespace TenantCloud\BetterReflection\Relocated\IteratorToArray;

use Traversable;
use function iterator_to_array;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param Traversable<string, int> $ints
     */
    public function doFoo(\Traversable $ints)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, int>', \iterator_to_array($ints));
    }
}
