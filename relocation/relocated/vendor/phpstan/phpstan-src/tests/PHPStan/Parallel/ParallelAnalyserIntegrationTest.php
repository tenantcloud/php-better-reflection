<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Parallel;

use TenantCloud\BetterReflection\Relocated\Nette\Utils\Json;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
/**
 * @group exec
 */
class ParallelAnalyserIntegrationTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function dataRun() : array
    {
        return [['analyse'], ['a']];
    }
    /**
     * @dataProvider dataRun
     * @param string $command
     */
    public function testRun(string $command) : void
    {
        \exec(\sprintf('%s %s clear-result-cache --configuration %s -q', \escapeshellarg(\PHP_BINARY), \escapeshellarg(__DIR__ . '/../../../bin/phpstan'), \escapeshellarg(__DIR__ . '/parallel-analyser.neon')), $clearResultCacheOutputLines, $clearResultCacheExitCode);
        if ($clearResultCacheExitCode !== 0) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException('Could not clear result cache.');
        }
        \exec(\sprintf('%s %s %s -l 8 -c %s --error-format json --no-progress %s', \escapeshellarg(\PHP_BINARY), \escapeshellarg(__DIR__ . '/../../../bin/phpstan'), $command, \escapeshellarg(__DIR__ . '/parallel-analyser.neon'), \implode(' ', \array_map(static function (string $path) : string {
            return \escapeshellarg($path);
        }, [__DIR__ . '/data/trait-definition.php', __DIR__ . '/data/traits.php']))), $outputLines, $exitCode);
        $output = \implode("\n", $outputLines);
        $fileHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper(__DIR__);
        $filePath = $fileHelper->normalizePath(__DIR__ . '/data/trait-definition.php');
        $this->assertJsonStringEqualsJsonString(\TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::encode(['totals' => ['errors' => 0, 'file_errors' => 3], 'files' => [\sprintf('%s (in context of class ParallelAnalyserIntegrationTest\\Bar)', $filePath) => ['errors' => 1, 'messages' => [['message' => 'Method ParallelAnalyserIntegrationTest\\Bar::doFoo() has no return typehint specified.', 'line' => 8, 'ignorable' => \true]]], \sprintf('%s (in context of class ParallelAnalyserIntegrationTest\\Foo)', $filePath) => ['errors' => 2, 'messages' => [['message' => 'Method ParallelAnalyserIntegrationTest\\Foo::doFoo() has no return typehint specified.', 'line' => 8, 'ignorable' => \true], ['message' => 'Access to an undefined property ParallelAnalyserIntegrationTest\\Foo::$test.', 'line' => 10, 'ignorable' => \true]]]], 'errors' => []]), $output);
        $this->assertSame(1, $exitCode);
    }
}
