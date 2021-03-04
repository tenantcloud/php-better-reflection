<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3134;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Registry
{
    /**
     * Map of type names and their corresponding flyweight objects.
     *
     * @var array<string, object>
     */
    private $instances = [];
    public function get(string $name) : object
    {
        return $this->instances[$name];
    }
}
function (\TenantCloud\BetterReflection\Relocated\Bug3134\Registry $r) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $r->get('x') === $r->get('x'));
};
