<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4011;

class Foo extends \FilterIterator
{
    public function __construct(\Traversable $iterator)
    {
    }
    public function accept()
    {
        return \true;
    }
}
function (\Traversable $t) {
    new \TenantCloud\BetterReflection\Relocated\Bug4011\Foo($t);
};
