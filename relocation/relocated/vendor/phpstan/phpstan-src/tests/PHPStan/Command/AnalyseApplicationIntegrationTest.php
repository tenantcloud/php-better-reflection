<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ResultCache\ResultCacheClearer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\TableErrorFormatter;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyOutput;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FuzzyRelativePathHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\NullRelativePathHelper;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle;
class AnalyseApplicationIntegrationTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testExecuteOnAFile() : void
    {
        $output = $this->runPath(__DIR__ . '/data/file-without-errors.php', 0);
        $this->assertStringContainsString('No errors', $output);
    }
    public function testExecuteOnANonExistentPath() : void
    {
        $path = __DIR__ . '/foo';
        $output = $this->runPath($path, 1);
        $this->assertStringContainsString(\sprintf('File %s does not exist.', $path), $output);
    }
    public function testExecuteOnAFileWithErrors() : void
    {
        $path = __DIR__ . '/../Rules/Functions/data/nonexistent-function.php';
        $output = $this->runPath($path, 1);
        $this->assertStringContainsString('Function foobarNonExistentFunction not found.', $output);
    }
    private function runPath(string $path, int $expectedStatusCode) : string
    {
        if (\PHP_VERSION_ID >= 80000 && \DIRECTORY_SEPARATOR === '\\') {
            $this->markTestSkipped('Skipped because of https://github.com/symfony/symfony/issues/37508');
        }
        self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ResultCache\ResultCacheClearer::class)->clear();
        $analyserApplication = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalyseApplication::class);
        $resource = \fopen('php://memory', 'w', \false);
        if ($resource === \false) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput($resource);
        $symfonyOutput = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyOutput($output, new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyStyle(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle($this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface::class), $output)));
        $memoryLimitFile = self::getContainer()->getParameter('memoryLimitFile');
        $relativePathHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FuzzyRelativePathHelper(new \TenantCloud\BetterReflection\Relocated\PHPStan\File\NullRelativePathHelper(), __DIR__, [], \DIRECTORY_SEPARATOR);
        $errorFormatter = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\TableErrorFormatter($relativePathHelper, \false);
        $analysisResult = $analyserApplication->analyse([$path], \true, $symfonyOutput, $symfonyOutput, \false, \false, null, null, $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface::class));
        if (\file_exists($memoryLimitFile)) {
            \unlink($memoryLimitFile);
        }
        $statusCode = $errorFormatter->formatErrors($analysisResult, $symfonyOutput);
        $this->assertSame($expectedStatusCode, $statusCode);
        \rewind($output->getStream());
        $contents = \stream_get_contents($output->getStream());
        if ($contents === \false) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return $contents;
    }
}
