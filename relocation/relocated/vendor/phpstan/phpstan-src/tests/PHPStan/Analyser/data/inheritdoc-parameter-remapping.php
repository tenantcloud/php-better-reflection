<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocParameterRemapping;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Lorem
{
    /**
     * @param B $b
     * @param C $c
     * @param A $a
     * @param D $d
     */
    public function doLorem($a, $b, $c, $d)
    {
    }
}
class Ipsum extends \TenantCloud\BetterReflection\Relocated\InheritDocParameterRemapping\Lorem
{
    public function doLorem($x, $y, $z, $d)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocParameterRemapping\\A', $x);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocParameterRemapping\\B', $y);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocParameterRemapping\\C', $z);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocParameterRemapping\\D', $d);
    }
}
class Dolor extends \TenantCloud\BetterReflection\Relocated\InheritDocParameterRemapping\Ipsum
{
    public function doLorem($g, $h, $i, $d)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocParameterRemapping\\A', $g);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocParameterRemapping\\B', $h);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocParameterRemapping\\C', $i);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InheritDocParameterRemapping\\D', $d);
    }
}
