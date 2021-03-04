<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\AnalyserResult;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\IgnoredErrorHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ResultCache\ResultCacheManagerFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Internal\BytesHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubValidator;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
class AnalyseApplication
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalyserRunner $analyserRunner;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubValidator $stubValidator;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ResultCache\ResultCacheManagerFactory $resultCacheManagerFactory;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\IgnoredErrorHelper $ignoredErrorHelper;
    private string $memoryLimitFile;
    private int $internalErrorsCountLimit;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalyserRunner $analyserRunner, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubValidator $stubValidator, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ResultCache\ResultCacheManagerFactory $resultCacheManagerFactory, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\IgnoredErrorHelper $ignoredErrorHelper, string $memoryLimitFile, int $internalErrorsCountLimit)
    {
        $this->analyserRunner = $analyserRunner;
        $this->stubValidator = $stubValidator;
        $this->resultCacheManagerFactory = $resultCacheManagerFactory;
        $this->ignoredErrorHelper = $ignoredErrorHelper;
        $this->memoryLimitFile = $memoryLimitFile;
        $this->internalErrorsCountLimit = $internalErrorsCountLimit;
    }
    /**
     * @param string[] $files
     * @param bool $onlyFiles
     * @param \PHPStan\Command\Output $stdOutput
     * @param \PHPStan\Command\Output $errorOutput
     * @param bool $defaultLevelUsed
     * @param bool $debug
     * @param string|null $projectConfigFile
     * @param mixed[]|null $projectConfigArray
     * @return AnalysisResult
     */
    public function analyse(array $files, bool $onlyFiles, \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $stdOutput, \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $errorOutput, bool $defaultLevelUsed, bool $debug, ?string $projectConfigFile, ?array $projectConfigArray, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input) : \TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult
    {
        $this->updateMemoryLimitFile();
        $projectStubFiles = [];
        if ($projectConfigArray !== null) {
            $projectStubFiles = $projectConfigArray['parameters']['stubFiles'] ?? [];
        }
        $stubErrors = $this->stubValidator->validate($projectStubFiles);
        \register_shutdown_function(function () : void {
            $error = \error_get_last();
            if ($error === null) {
                return;
            }
            if ($error['type'] !== \E_ERROR) {
                return;
            }
            if (\strpos($error['message'], 'Allowed memory size') !== \false) {
                return;
            }
            @\unlink($this->memoryLimitFile);
        });
        $resultCacheManager = $this->resultCacheManagerFactory->create([]);
        $ignoredErrorHelperResult = $this->ignoredErrorHelper->initialize();
        if (\count($ignoredErrorHelperResult->getErrors()) > 0) {
            $errors = $ignoredErrorHelperResult->getErrors();
            $warnings = [];
            $internalErrors = [];
            $savedResultCache = \false;
            if ($errorOutput->isDebug()) {
                $errorOutput->writeLineFormatted('Result cache was not saved because of ignoredErrorHelperResult errors.');
            }
        } else {
            $resultCache = $resultCacheManager->restore($files, $debug, $onlyFiles, $projectConfigArray, $errorOutput);
            $intermediateAnalyserResult = $this->runAnalyser($resultCache->getFilesToAnalyse(), $files, $debug, $projectConfigFile, $stdOutput, $errorOutput, $input);
            $resultCacheResult = $resultCacheManager->process($intermediateAnalyserResult, $resultCache, $errorOutput, $onlyFiles, \true);
            $analyserResult = $resultCacheResult->getAnalyserResult();
            $internalErrors = $analyserResult->getInternalErrors();
            $errors = $ignoredErrorHelperResult->process($analyserResult->getErrors(), $onlyFiles, $files, \count($internalErrors) > 0 || $analyserResult->hasReachedInternalErrorsCountLimit());
            $warnings = $ignoredErrorHelperResult->getWarnings();
            $savedResultCache = $resultCacheResult->isSaved();
            if ($analyserResult->hasReachedInternalErrorsCountLimit()) {
                $errors[] = \sprintf('Reached internal errors count limit of %d, exiting...', $this->internalErrorsCountLimit);
            }
            $errors = \array_merge($errors, $internalErrors);
        }
        $errors = \array_merge($stubErrors, $errors);
        $fileSpecificErrors = [];
        $notFileSpecificErrors = [];
        foreach ($errors as $error) {
            if (\is_string($error)) {
                $notFileSpecificErrors[] = $error;
                continue;
            }
            $fileSpecificErrors[] = $error;
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult($fileSpecificErrors, $notFileSpecificErrors, $internalErrors, $warnings, $defaultLevelUsed, $projectConfigFile, $savedResultCache);
    }
    /**
     * @param string[] $files
     * @param string[] $allAnalysedFiles
     */
    private function runAnalyser(array $files, array $allAnalysedFiles, bool $debug, ?string $projectConfigFile, \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $stdOutput, \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $errorOutput, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\AnalyserResult
    {
        $filesCount = \count($files);
        $allAnalysedFilesCount = \count($allAnalysedFiles);
        if ($filesCount === 0) {
            $errorOutput->getStyle()->progressStart($allAnalysedFilesCount);
            $errorOutput->getStyle()->progressAdvance($allAnalysedFilesCount);
            $errorOutput->getStyle()->progressFinish();
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\AnalyserResult([], [], [], [], \false);
        }
        if (!$debug) {
            $progressStarted = \false;
            $fileOrder = 0;
            $preFileCallback = null;
            $postFileCallback = function (int $step) use($errorOutput, &$progressStarted, $allAnalysedFilesCount, $filesCount, &$fileOrder) : void {
                if (!$progressStarted) {
                    $errorOutput->getStyle()->progressStart($allAnalysedFilesCount);
                    $errorOutput->getStyle()->progressAdvance($allAnalysedFilesCount - $filesCount);
                    $progressStarted = \true;
                }
                $errorOutput->getStyle()->progressAdvance($step);
                if ($fileOrder >= 100) {
                    $this->updateMemoryLimitFile();
                    $fileOrder = 0;
                }
                $fileOrder += $step;
            };
        } else {
            $preFileCallback = static function (string $file) use($stdOutput) : void {
                $stdOutput->writeLineFormatted($file);
            };
            $postFileCallback = null;
            if ($stdOutput->isDebug()) {
                $previousMemory = \memory_get_peak_usage(\true);
                $postFileCallback = static function () use($stdOutput, &$previousMemory) : void {
                    $currentTotalMemory = \memory_get_peak_usage(\true);
                    $stdOutput->writeLineFormatted(\sprintf('--- consumed %s, total %s', \TenantCloud\BetterReflection\Relocated\PHPStan\Internal\BytesHelper::bytes($currentTotalMemory - $previousMemory), \TenantCloud\BetterReflection\Relocated\PHPStan\Internal\BytesHelper::bytes($currentTotalMemory)));
                    $previousMemory = $currentTotalMemory;
                };
            }
        }
        $analyserResult = $this->analyserRunner->runAnalyser($files, $allAnalysedFiles, $preFileCallback, $postFileCallback, $debug, \true, $projectConfigFile, null, null, $input);
        if (isset($progressStarted) && $progressStarted) {
            $errorOutput->getStyle()->progressFinish();
        }
        return $analyserResult;
    }
    private function updateMemoryLimitFile() : void
    {
        $bytes = \memory_get_peak_usage(\true);
        $megabytes = \ceil($bytes / 1024 / 1024);
        \file_put_contents($this->memoryLimitFile, \sprintf('%d MB', $megabytes));
    }
}
