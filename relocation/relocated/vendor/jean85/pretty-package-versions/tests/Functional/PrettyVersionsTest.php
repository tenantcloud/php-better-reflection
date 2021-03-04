<?php

namespace TenantCloud\BetterReflection\Relocated\Tests\Functional;

use TenantCloud\BetterReflection\Relocated\Jean85\PrettyVersions;
use TenantCloud\BetterReflection\Relocated\Jean85\Version;
use TenantCloud\BetterReflection\Relocated\PackageVersions\Versions;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
class PrettyVersionsTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testVersion()
    {
        $version = \TenantCloud\BetterReflection\Relocated\Jean85\PrettyVersions::getVersion('phpunit/phpunit');
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\Jean85\Version::class, $version);
        $this->assertSame('phpunit/phpunit', $version->getPackageName());
        $this->assertSame(\TenantCloud\BetterReflection\Relocated\PackageVersions\Versions::getVersion('phpunit/phpunit'), $version->getFullVersion());
    }
    public function testVersionLetsExceptionRaise()
    {
        $this->expectException(\Throwable::class);
        \TenantCloud\BetterReflection\Relocated\Jean85\PrettyVersions::getVersion('non-existent-vendor/non-existent-package');
    }
    public function testGetRootPackageName()
    {
        $this->assertSame('jean85/pretty-package-versions', \TenantCloud\BetterReflection\Relocated\Jean85\PrettyVersions::getRootPackageName());
    }
    public function testGetRootPackageVersion()
    {
        $version = \TenantCloud\BetterReflection\Relocated\Jean85\PrettyVersions::getRootPackageVersion();
        $this->assertSame('jean85/pretty-package-versions', $version->getPackageName());
        $this->assertEquals(\TenantCloud\BetterReflection\Relocated\Jean85\PrettyVersions::getVersion('jean85/pretty-package-versions'), $version);
    }
}
