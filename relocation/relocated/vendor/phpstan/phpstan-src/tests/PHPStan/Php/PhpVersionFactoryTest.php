<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Php;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
class PhpVersionFactoryTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function dataCreate() : array
    {
        return [[null, null, \PHP_VERSION_ID, null], [70200, null, 70200, '7.2'], [70200, '7.4.6', 70200, '7.2'], [null, '7.4.6', 70406, '7.4.6'], [null, '7.0', 70100, '7.1'], [null, '7.1.1', 70101, '7.1.1'], [null, '5.4.1', 70100, '7.1'], [null, '8.1', 80000, '8.0']];
    }
    /**
     * @dataProvider dataCreate
     * @param int|null $versionId
     * @param string|null $composerPhpVersion
     * @param int $expectedVersion
     * @param string|null $expectedVersionString
     */
    public function testCreate(?int $versionId, ?string $composerPhpVersion, int $expectedVersion, ?string $expectedVersionString) : void
    {
        $factory = new \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersionFactory($versionId, $composerPhpVersion);
        $phpVersion = $factory->create();
        $this->assertSame($expectedVersion, $phpVersion->getVersionId());
        if ($expectedVersionString === null) {
            return;
        }
        $this->assertSame($expectedVersionString, $phpVersion->getVersionString());
    }
}
