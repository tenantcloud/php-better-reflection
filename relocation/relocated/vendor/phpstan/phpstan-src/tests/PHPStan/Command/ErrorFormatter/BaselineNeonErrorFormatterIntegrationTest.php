<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter;

use TenantCloud\BetterReflection\Relocated\Nette\Utils\Json;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use function chdir;
use function file_put_contents;
use function getcwd;
/**
 * @group exec
 */
class BaselineNeonErrorFormatterIntegrationTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testErrorWithTrait() : void
    {
        $output = $this->runPhpStan(__DIR__ . '/data/', null);
        $errors = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::decode($output, \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::FORCE_ARRAY);
        $this->assertSame(10, \array_sum($errors['totals']));
        $this->assertCount(6, $errors['files']);
    }
    public function testGenerateBaselineAndRunAgainWithIt() : void
    {
        $output = $this->runPhpStan(__DIR__ . '/data/', null, 'baselineNeon');
        $baselineFile = __DIR__ . '/../../../../baseline.neon';
        \file_put_contents($baselineFile, $output);
        $output = $this->runPhpStan(__DIR__ . '/data/', $baselineFile);
        @\unlink($baselineFile);
        $errors = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::decode($output, \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::FORCE_ARRAY);
        $this->assertSame(0, \array_sum($errors['totals']));
        $this->assertCount(0, $errors['files']);
    }
    public function testRunWindowsFileWithUnixBaseline() : void
    {
        $output = $this->runPhpStan(__DIR__ . '/data/WindowsNewlines.php', __DIR__ . '/data/unixBaseline.neon');
        $errors = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::decode($output, \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::FORCE_ARRAY);
        $this->assertSame(0, \array_sum($errors['totals']));
        $this->assertCount(0, $errors['files']);
    }
    public function testRunUnixFileWithWindowsBaseline() : void
    {
        $output = $this->runPhpStan(__DIR__ . '/data/UnixNewlines.php', __DIR__ . '/data/windowsBaseline.neon');
        $errors = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::decode($output, \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::FORCE_ARRAY);
        $this->assertSame(0, \array_sum($errors['totals']));
        $this->assertCount(0, $errors['files']);
    }
    private function runPhpStan(string $analysedPath, ?string $configFile, string $errorFormatter = 'json') : string
    {
        $originalDir = \getcwd();
        if ($originalDir === \false) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        \chdir(__DIR__ . '/../../../..');
        \exec(\sprintf('%s %s clear-result-cache %s', \escapeshellarg(\PHP_BINARY), 'bin/phpstan', $configFile !== null ? '--configuration ' . \escapeshellarg($configFile) : ''), $clearResultCacheOutputLines, $clearResultCacheExitCode);
        if ($clearResultCacheExitCode !== 0) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException('Could not clear result cache.');
        }
        \exec(\sprintf('%s %s analyse --no-progress --error-format=%s --level=7 %s %s', \escapeshellarg(\PHP_BINARY), 'bin/phpstan', $errorFormatter, $configFile !== null ? '--configuration ' . \escapeshellarg($configFile) : '', \escapeshellarg($analysedPath)), $outputLines);
        \chdir($originalDir);
        return \implode("\n", $outputLines);
    }
}
