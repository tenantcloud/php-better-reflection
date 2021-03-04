<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Internal;

class BytesHelper
{
    public static function bytes(int $bytes) : string
    {
        $bytes = \round($bytes);
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
        foreach ($units as $unit) {
            if (\abs($bytes) < 1024 || $unit === \end($units)) {
                break;
            }
            $bytes /= 1024;
        }
        if (!isset($unit)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return \round($bytes, 2) . ' ' . $unit;
    }
}
