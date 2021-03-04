<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2112;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function getFoos() : array
    {
        return [];
    }
    public function doBar() : void
    {
        $foos = $this->getFoos();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', $foos);
        $foos[0] = null;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', $foos[0]);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array&nonEmpty', $foos);
    }
    /** @return self[] */
    public function getFooBars() : array
    {
        return [];
    }
    public function doBars() : void
    {
        $foos = $this->getFooBars();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<Bug2112\\Foo>', $foos);
        $foos[0] = null;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', $foos[0]);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<Bug2112\\Foo|null>&nonEmpty', $foos);
    }
}
