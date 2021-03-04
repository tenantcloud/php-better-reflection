<?php

namespace TenantCloud\BetterReflection\Relocated\Jean85;

use TenantCloud\BetterReflection\Relocated\PackageVersions\Versions;
class PrettyVersions
{
    const SHORT_COMMIT_LENGTH = 7;
    public static function getVersion(string $packageName) : \TenantCloud\BetterReflection\Relocated\Jean85\Version
    {
        return new \TenantCloud\BetterReflection\Relocated\Jean85\Version($packageName, \TenantCloud\BetterReflection\Relocated\PackageVersions\Versions::getVersion($packageName));
    }
    public static function getRootPackageName() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PackageVersions\Versions::ROOT_PACKAGE_NAME;
    }
    public static function getRootPackageVersion() : \TenantCloud\BetterReflection\Relocated\Jean85\Version
    {
        return self::getVersion(\TenantCloud\BetterReflection\Relocated\PackageVersions\Versions::ROOT_PACKAGE_NAME);
    }
}
