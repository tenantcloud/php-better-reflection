<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Testing;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorsConsoleStyle;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyOutput;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyStyle;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput;
abstract class ErrorFormatterTestCase extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    protected const DIRECTORY_PATH = '/data/folder/with space/and unicode 😃/project';
    private ?\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput $outputStream = null;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $output = null;
    private function getOutputStream() : \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput
    {
        if (\PHP_VERSION_ID >= 80000 && \DIRECTORY_SEPARATOR === '\\') {
            $this->markTestSkipped('Skipped because of https://github.com/symfony/symfony/issues/37508');
        }
        if ($this->outputStream === null) {
            $resource = \fopen('php://memory', 'w', \false);
            if ($resource === \false) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $this->outputStream = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput($resource);
        }
        return $this->outputStream;
    }
    protected function getOutput() : \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output
    {
        if ($this->output === null) {
            $errorConsoleStyle = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorsConsoleStyle(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput(''), $this->getOutputStream());
            $this->output = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyOutput($this->getOutputStream(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyStyle($errorConsoleStyle));
        }
        return $this->output;
    }
    protected function getOutputContent() : string
    {
        \rewind($this->getOutputStream()->getStream());
        $contents = \stream_get_contents($this->getOutputStream()->getStream());
        if ($contents === \false) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return $this->rtrimMultiline($contents);
    }
    protected function getAnalysisResult(int $numFileErrors, int $numGenericErrors) : \TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult
    {
        if ($numFileErrors > 4 || $numFileErrors < 0 || $numGenericErrors > 2 || $numGenericErrors < 0) {
            throw new \Exception();
        }
        $fileErrors = \array_slice([new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('Foo', self::DIRECTORY_PATH . '/folder with unicode 😃/file name with "spaces" and unicode 😃.php', 4), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('Foo', self::DIRECTORY_PATH . '/foo.php', 1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error("Bar\nBar2", self::DIRECTORY_PATH . '/foo.php', 5), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error("Bar\nBar2", self::DIRECTORY_PATH . '/folder with unicode 😃/file name with "spaces" and unicode 😃.php', 2)], 0, $numFileErrors);
        $genericErrors = \array_slice(['first generic error', 'second generic error'], 0, $numGenericErrors);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult($fileErrors, $genericErrors, [], [], \false, null, \true);
    }
    private function rtrimMultiline(string $output) : string
    {
        $result = \array_map(static function (string $line) : string {
            return \rtrim($line, " \r\n");
        }, \explode("\n", $output));
        return \implode("\n", $result);
    }
}
