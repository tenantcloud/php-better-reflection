<?php

namespace TenantCloud\BetterReflection\Relocated\Bug801;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class HelloWorld
{
    public function getDateTime() : ?\DateTime
    {
        return (bool) \rand(0, 1) ? new \DateTime('now') : null;
    }
}
function () : void {
    $hello = new \TenantCloud\BetterReflection\Relocated\Bug801\HelloWorld();
    $dt = $hello->getDateTime();
    $condition = null !== $dt;
    if ($condition) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTime', $dt);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', $dt);
    }
};
