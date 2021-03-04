<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4436;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Bar
{
}
class Foo
{
    /** @var \SplObjectStorage<Bar, string> */
    private $storage;
    public function __construct()
    {
        $this->storage = new \SplObjectStorage();
    }
    public function add(\TenantCloud\BetterReflection\Relocated\Bug4436\Bar $bar, string $value) : void
    {
        $this->storage[$bar] = $value;
    }
    public function get(\TenantCloud\BetterReflection\Relocated\Bug4436\Bar $bar) : string
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $this->storage[$bar]);
        return $this->storage[$bar];
    }
}
