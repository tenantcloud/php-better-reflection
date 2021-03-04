<?php

namespace TenantCloud\BetterReflection\Relocated\PropertyAssignIntersectionStaticTypeBug;

abstract class Base
{
    /** @var string */
    private $foo;
    public function __construct(string $foo)
    {
        \assert($this instanceof \TenantCloud\BetterReflection\Relocated\PropertyAssignIntersectionStaticTypeBug\Frontend || $this instanceof \TenantCloud\BetterReflection\Relocated\PropertyAssignIntersectionStaticTypeBug\Backend);
        $this->foo = $foo;
    }
}
class Frontend extends \TenantCloud\BetterReflection\Relocated\PropertyAssignIntersectionStaticTypeBug\Base
{
}
class Backend extends \TenantCloud\BetterReflection\Relocated\PropertyAssignIntersectionStaticTypeBug\Base
{
}
