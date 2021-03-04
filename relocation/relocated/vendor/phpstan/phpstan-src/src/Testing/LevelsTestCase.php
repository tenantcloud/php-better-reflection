<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Testing;

use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileWriter;
abstract class LevelsTestCase extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @return array<array<string>>
     */
    public abstract function dataTopics() : array;
    public abstract function getDataPath() : string;
    public abstract function getPhpStanExecutablePath() : string;
    public abstract function getPhpStanConfigPath() : ?string;
    protected function getResultSuffix() : string
    {
        return '';
    }
    protected function shouldAutoloadAnalysedFile() : bool
    {
        return \true;
    }
    /**
     * @dataProvider dataTopics
     * @param string $topic
     */
    public function testLevels(string $topic) : void
    {
        $file = \sprintf('%s' . \DIRECTORY_SEPARATOR . '%s.php', $this->getDataPath(), $topic);
        $command = \escapeshellcmd($this->getPhpStanExecutablePath());
        $configPath = $this->getPhpStanConfigPath();
        $fileHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper(__DIR__ . '/../..');
        $previousMessages = [];
        $exceptions = [];
        foreach (\range(0, 8) as $level) {
            unset($outputLines);
            \exec(\sprintf('%s %s clear-result-cache %s 2>&1', \escapeshellarg(\PHP_BINARY), $command, $configPath !== null ? '--configuration ' . \escapeshellarg($configPath) : ''), $clearResultCacheOutputLines, $clearResultCacheExitCode);
            if ($clearResultCacheExitCode !== 0) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException('Could not clear result cache: ' . \implode("\n", $clearResultCacheOutputLines));
            }
            \exec(\sprintf('%s %s analyse --no-progress --error-format=prettyJson --level=%d %s %s %s', \escapeshellarg(\PHP_BINARY), $command, $level, $configPath !== null ? '--configuration ' . \escapeshellarg($configPath) : '', $this->shouldAutoloadAnalysedFile() ? \sprintf('--autoload-file %s', \escapeshellarg($file)) : '', \escapeshellarg($file)), $outputLines);
            $output = \implode("\n", $outputLines);
            try {
                $actualJson = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::decode($output, \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::FORCE_ARRAY);
            } catch (\TenantCloud\BetterReflection\Relocated\Nette\Utils\JsonException $e) {
                throw new \TenantCloud\BetterReflection\Relocated\Nette\Utils\JsonException(\sprintf('Cannot decode: %s', $output));
            }
            if (\count($actualJson['files']) > 0) {
                $normalizedFilePath = $fileHelper->normalizePath($file);
                if (!isset($actualJson['files'][$normalizedFilePath])) {
                    $messagesBeforeDiffing = [];
                } else {
                    $messagesBeforeDiffing = $actualJson['files'][$normalizedFilePath]['messages'];
                }
                foreach ($this->getAdditionalAnalysedFiles() as $additionalAnalysedFile) {
                    $normalizedAdditionalFilePath = $fileHelper->normalizePath($additionalAnalysedFile);
                    if (!isset($actualJson['files'][$normalizedAdditionalFilePath])) {
                        continue;
                    }
                    $messagesBeforeDiffing = \array_merge($messagesBeforeDiffing, $actualJson['files'][$normalizedAdditionalFilePath]['messages']);
                }
            } else {
                $messagesBeforeDiffing = [];
            }
            $messages = [];
            foreach ($messagesBeforeDiffing as $message) {
                foreach ($previousMessages as $lastMessage) {
                    if ($message['message'] === $lastMessage['message'] && $message['line'] === $lastMessage['line']) {
                        continue 2;
                    }
                }
                $messages[] = $message;
            }
            $missingMessages = [];
            foreach ($previousMessages as $previousMessage) {
                foreach ($messagesBeforeDiffing as $message) {
                    if ($previousMessage['message'] === $message['message'] && $previousMessage['line'] === $message['line']) {
                        continue 2;
                    }
                }
                $missingMessages[] = $previousMessage;
            }
            $previousMessages = \array_merge($previousMessages, $messages);
            $expectedJsonFile = \sprintf('%s/%s-%d%s.json', $this->getDataPath(), $topic, $level, $this->getResultSuffix());
            $exception = $this->compareFiles($expectedJsonFile, $messages);
            if ($exception !== null) {
                $exceptions[] = $exception;
            }
            $expectedJsonMissingFile = \sprintf('%s/%s-%d-missing%s.json', $this->getDataPath(), $topic, $level, $this->getResultSuffix());
            $exception = $this->compareFiles($expectedJsonMissingFile, $missingMessages);
            if ($exception === null) {
                continue;
            }
            $exceptions[] = $exception;
        }
        if (\count($exceptions) > 0) {
            throw $exceptions[0];
        }
    }
    /**
     * @return string[]
     */
    public function getAdditionalAnalysedFiles() : array
    {
        return [];
    }
    /**
     * @param string $expectedJsonFile
     * @param string[] $expectedMessages
     * @return \PHPUnit\Framework\AssertionFailedError|null
     */
    private function compareFiles(string $expectedJsonFile, array $expectedMessages) : ?\TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\AssertionFailedError
    {
        if (\count($expectedMessages) === 0) {
            try {
                self::assertFileNotExists($expectedJsonFile);
                return null;
            } catch (\TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\AssertionFailedError $e) {
                \unlink($expectedJsonFile);
                return $e;
            }
        }
        $actualOutput = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::encode($expectedMessages, \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::PRETTY);
        try {
            $this->assertJsonStringEqualsJsonFile($expectedJsonFile, $actualOutput);
        } catch (\TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\AssertionFailedError $e) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileWriter::write($expectedJsonFile, $actualOutput);
            return $e;
        }
        return null;
    }
    public static function assertFileNotExists(string $filename, string $message = '') : void
    {
        if (\method_exists(self::class, 'assertFileDoesNotExist')) {
            self::assertFileDoesNotExist($filename, $message);
            // @phpstan-ignore-line
            return;
        }
        parent::assertFileNotExists($filename, $message);
    }
}
