<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3986;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
interface Boo
{
    public function nullable() : ?int;
}
class HelloWorld
{
    public function sayHello(\TenantCloud\BetterReflection\Relocated\Bug3986\Boo $value) : void
    {
        $result = $value->nullable();
        $isNotNull = $result !== null;
        if ($isNotNull) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $result);
        }
        if ($result !== null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $result);
        }
    }
}
