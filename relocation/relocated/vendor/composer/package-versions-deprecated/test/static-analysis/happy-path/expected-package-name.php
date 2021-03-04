<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\PackageVersions\Versions;
/** @psalm-pure */
function getVersion() : string
{
    return \TenantCloud\BetterReflection\Relocated\PackageVersions\Versions::getVersion('composer/package-versions-deprecated');
}
