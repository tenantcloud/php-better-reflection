<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4415;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @implements \IteratorAggregate<int, string>
 */
class Foo implements \IteratorAggregate
{
    public function getIterator() : \Iterator
    {
    }
}
function (\TenantCloud\BetterReflection\Relocated\Bug4415\Foo $foo) : void {
    foreach ($foo as $k => $v) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $k);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $v);
    }
};
