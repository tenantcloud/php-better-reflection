<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command;

use TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\CiDetector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ResultCache\ResultCacheClearer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\BaselineNeonErrorFormatter;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\ErrorFormatter;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\TableErrorFormatter;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyOutput;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyStyle;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileWriter;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\ParentDirectoryRelativePathHelper;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput;
use function stream_get_contents;
class AnalyseCommand extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command
{
    private const NAME = 'analyse';
    public const OPTION_LEVEL = 'level';
    public const DEFAULT_LEVEL = \TenantCloud\BetterReflection\Relocated\PHPStan\Command\CommandHelper::DEFAULT_LEVEL;
    /** @var string[] */
    private array $composerAutoloaderProjectPaths;
    /**
     * @param string[] $composerAutoloaderProjectPaths
     */
    public function __construct(array $composerAutoloaderProjectPaths)
    {
        parent::__construct();
        $this->composerAutoloaderProjectPaths = $composerAutoloaderProjectPaths;
    }
    protected function configure() : void
    {
        $this->setName(self::NAME)->setDescription('Analyses source code')->setDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('paths', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::OPTIONAL | \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Paths with source code to run analysis on'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('paths-file', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to a file with a list of paths to run analysis on'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('configuration', 'c', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to project configuration file'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption(self::OPTION_LEVEL, 'l', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Level of rule options - the higher the stricter'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption(\TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorsConsoleStyle::OPTION_NO_PROGRESS, null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Do not show progress bar, only results'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('debug', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Show debug information - which file is analysed, do not catch internal errors'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('autoload-file', 'a', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Project\'s additional autoload file path'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('error-format', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Format in which to print the result of the analysis', null), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('generate-baseline', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL, 'Path to a file where the baseline should be saved', \false), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('memory-limit', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Memory limit for analysis'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('xdebug', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Allow running with XDebug for debugging purposes'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('fix', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Launch PHPStan Pro'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('watch', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Launch PHPStan Pro'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('pro', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Launch PHPStan Pro')]);
    }
    /**
     * @return string[]
     */
    public function getAliases() : array
    {
        return ['analyze'];
    }
    protected function initialize(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) : void
    {
        if ((bool) $input->getOption('debug')) {
            $application = $this->getApplication();
            if ($application === null) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $application->setCatchExceptions(\false);
            return;
        }
    }
    protected function execute(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $paths = $input->getArgument('paths');
        $memoryLimit = $input->getOption('memory-limit');
        $autoloadFile = $input->getOption('autoload-file');
        $configuration = $input->getOption('configuration');
        $level = $input->getOption(self::OPTION_LEVEL);
        $pathsFile = $input->getOption('paths-file');
        $allowXdebug = $input->getOption('xdebug');
        $debugEnabled = (bool) $input->getOption('debug');
        $fix = (bool) $input->getOption('fix') || (bool) $input->getOption('watch') || (bool) $input->getOption('pro');
        /** @var string|false|null $generateBaselineFile */
        $generateBaselineFile = $input->getOption('generate-baseline');
        if ($generateBaselineFile === \false) {
            $generateBaselineFile = null;
        } elseif ($generateBaselineFile === null) {
            $generateBaselineFile = 'phpstan-baseline.neon';
        }
        if (!\is_array($paths) || !\is_string($memoryLimit) && $memoryLimit !== null || !\is_string($autoloadFile) && $autoloadFile !== null || !\is_string($configuration) && $configuration !== null || !\is_string($level) && $level !== null || !\is_string($pathsFile) && $pathsFile !== null || !\is_bool($allowXdebug)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        try {
            $inceptionResult = \TenantCloud\BetterReflection\Relocated\PHPStan\Command\CommandHelper::begin($input, $output, $paths, $pathsFile, $memoryLimit, $autoloadFile, $this->composerAutoloaderProjectPaths, $configuration, $generateBaselineFile, $level, $allowXdebug, \true, $debugEnabled);
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException $e) {
            return 1;
        }
        $errorOutput = $inceptionResult->getErrorOutput();
        $obsoleteDockerImage = $_SERVER['PHPSTAN_OBSOLETE_DOCKER_IMAGE'] ?? 'false';
        if ($obsoleteDockerImage === 'true') {
            $errorOutput->writeLineFormatted('⚠️  You\'re using an obsolete PHPStan Docker image. ⚠️️');
            $errorOutput->writeLineFormatted('   You can obtain the current one from <fg=cyan>ghcr.io/phpstan/phpstan</>.');
            $errorOutput->writeLineFormatted('   Read more about it here:');
            $errorOutput->writeLineFormatted('   <fg=cyan>https://phpstan.org/user-guide/docker</>');
            $errorOutput->writeLineFormatted('');
        }
        $errorFormat = $input->getOption('error-format');
        if (!\is_string($errorFormat) && $errorFormat !== null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        if ($errorFormat === null) {
            $errorFormat = 'table';
            $ciDetector = new \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\CiDetector();
            try {
                $ci = $ciDetector->detect();
                if ($ci->getCiName() === \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\CiDetector::CI_GITHUB_ACTIONS) {
                    $errorFormat = 'github';
                } elseif ($ci->getCiName() === \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\CiDetector::CI_TEAMCITY) {
                    $errorFormat = 'teamcity';
                }
            } catch (\TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Exception\CiNotDetectedException $e) {
                // pass
            }
        }
        $container = $inceptionResult->getContainer();
        $errorFormatterServiceName = \sprintf('errorFormatter.%s', $errorFormat);
        if (!$container->hasService($errorFormatterServiceName)) {
            $errorOutput->writeLineFormatted(\sprintf('Error formatter "%s" not found. Available error formatters are: %s', $errorFormat, \implode(', ', \array_map(static function (string $name) : string {
                return \substr($name, \strlen('errorFormatter.'));
            }, $container->findServiceNamesByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\ErrorFormatter::class)))));
            return 1;
        }
        if ($errorFormat === 'baselineNeon') {
            $errorOutput = $inceptionResult->getErrorOutput();
            $errorOutput->writeLineFormatted('⚠️  You\'re using an obsolete option <fg=cyan>--error-format baselineNeon</>. ⚠️️');
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted('   There\'s a new and much better option <fg=cyan>--generate-baseline</>. Here are the advantages:');
            $errorOutput->writeLineFormatted('   1) The current baseline file does not have to be commented-out');
            $errorOutput->writeLineFormatted('      nor emptied when generating the new baseline. It\'s excluded automatically.');
            $errorOutput->writeLineFormatted('   2) Output no longer has to be redirected to a file, PHPStan saves the baseline');
            $errorOutput->writeLineFormatted('      to a specified path (defaults to <fg=cyan>phpstan-baseline.neon</>).');
            $errorOutput->writeLineFormatted('   3) Baseline contains correct relative paths if saved to a subdirectory.');
            $errorOutput->writeLineFormatted('');
        }
        $generateBaselineFile = $inceptionResult->getGenerateBaselineFile();
        if ($generateBaselineFile !== null) {
            $baselineExtension = \pathinfo($generateBaselineFile, \PATHINFO_EXTENSION);
            if ($baselineExtension === '') {
                $inceptionResult->getStdOutput()->getStyle()->error(\sprintf('Baseline filename must have an extension, %s provided instead.', \pathinfo($generateBaselineFile, \PATHINFO_BASENAME)));
                return $inceptionResult->handleReturn(1);
            }
            if ($baselineExtension !== 'neon') {
                $inceptionResult->getStdOutput()->getStyle()->error(\sprintf('Baseline filename extension must be .neon, .%s was used instead.', $baselineExtension));
                return $inceptionResult->handleReturn(1);
            }
        }
        try {
            [$files, $onlyFiles] = $inceptionResult->getFiles();
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\File\PathNotFoundException $e) {
            $inceptionResult->getErrorOutput()->writeLineFormatted(\sprintf('<error>%s</error>', $e->getMessage()));
            return 1;
        }
        /** @var AnalyseApplication  $application */
        $application = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalyseApplication::class);
        $debug = $input->getOption('debug');
        if (!\is_bool($debug)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $analysisResult = $application->analyse($files, $onlyFiles, $inceptionResult->getStdOutput(), $inceptionResult->getErrorOutput(), $inceptionResult->isDefaultLevelUsed(), $debug, $inceptionResult->getProjectConfigFile(), $inceptionResult->getProjectConfigArray(), $input);
        if ($generateBaselineFile !== null) {
            if (!$analysisResult->hasErrors()) {
                $inceptionResult->getStdOutput()->getStyle()->error('No errors were found during the analysis. Baseline could not be generated.');
                return $inceptionResult->handleReturn(1);
            }
            if ($analysisResult->hasInternalErrors()) {
                $inceptionResult->getStdOutput()->getStyle()->error('An internal error occurred. Baseline could not be generated. Re-run PHPStan without --generate-baseline to see what\'s going on.');
                return $inceptionResult->handleReturn(1);
            }
            $baselineFileDirectory = \dirname($generateBaselineFile);
            $baselineErrorFormatter = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\BaselineNeonErrorFormatter(new \TenantCloud\BetterReflection\Relocated\PHPStan\File\ParentDirectoryRelativePathHelper($baselineFileDirectory));
            $streamOutput = $this->createStreamOutput();
            $errorConsoleStyle = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorsConsoleStyle(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput(''), $streamOutput);
            $baselineOutput = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyOutput($streamOutput, new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyStyle($errorConsoleStyle));
            $baselineErrorFormatter->formatErrors($analysisResult, $baselineOutput);
            $stream = $streamOutput->getStream();
            \rewind($stream);
            $baselineContents = \stream_get_contents($stream);
            if ($baselineContents === \false) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            if (!\is_dir($baselineFileDirectory)) {
                $mkdirResult = @\mkdir($baselineFileDirectory, 0644, \true);
                if ($mkdirResult === \false) {
                    $inceptionResult->getStdOutput()->writeLineFormatted(\sprintf('Failed to create directory "%s".', $baselineFileDirectory));
                    return $inceptionResult->handleReturn(1);
                }
            }
            try {
                \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileWriter::write($generateBaselineFile, $baselineContents);
            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\File\CouldNotWriteFileException $e) {
                $inceptionResult->getStdOutput()->writeLineFormatted($e->getMessage());
                return $inceptionResult->handleReturn(1);
            }
            $errorsCount = 0;
            $unignorableCount = 0;
            foreach ($analysisResult->getFileSpecificErrors() as $fileSpecificError) {
                if (!$fileSpecificError->canBeIgnored()) {
                    $unignorableCount++;
                    if ($output->isVeryVerbose()) {
                        $inceptionResult->getStdOutput()->writeLineFormatted('Unignorable could not be added to the baseline:');
                        $inceptionResult->getStdOutput()->writeLineFormatted($fileSpecificError->getMessage());
                        $inceptionResult->getStdOutput()->writeLineFormatted($fileSpecificError->getFile());
                        $inceptionResult->getStdOutput()->writeLineFormatted('');
                    }
                    continue;
                }
                $errorsCount++;
            }
            $message = \sprintf('Baseline generated with %d %s.', $errorsCount, $errorsCount === 1 ? 'error' : 'errors');
            if ($unignorableCount === 0 && \count($analysisResult->getNotFileSpecificErrors()) === 0) {
                $inceptionResult->getStdOutput()->getStyle()->success($message);
            } else {
                $inceptionResult->getStdOutput()->getStyle()->warning($message . "\nSome errors could not be put into baseline. Re-run PHPStan and fix them.");
            }
            return $inceptionResult->handleReturn(0);
        }
        if ($fix) {
            $ciDetector = new \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\CiDetector();
            if ($ciDetector->isCiDetected()) {
                $inceptionResult->getStdOutput()->writeLineFormatted('PHPStan Pro can\'t run in CI environment yet. Stay tuned!');
                return $inceptionResult->handleReturn(1);
            }
            $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ResultCache\ResultCacheClearer::class)->clearTemporaryCaches();
            $hasInternalErrors = $analysisResult->hasInternalErrors();
            $nonIgnorableErrorsByException = [];
            foreach ($analysisResult->getFileSpecificErrors() as $fileSpecificError) {
                if (!$fileSpecificError->hasNonIgnorableException()) {
                    continue;
                }
                $nonIgnorableErrorsByException[] = $fileSpecificError;
            }
            if ($hasInternalErrors || \count($nonIgnorableErrorsByException) > 0) {
                $fixerAnalysisResult = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult($nonIgnorableErrorsByException, $analysisResult->getInternalErrors(), $analysisResult->getInternalErrors(), [], $analysisResult->isDefaultLevelUsed(), $analysisResult->getProjectConfigFile(), $analysisResult->isResultCacheSaved());
                $stdOutput = $inceptionResult->getStdOutput();
                $stdOutput->getStyle()->error('PHPStan Pro can\'t be launched because of these errors:');
                /** @var TableErrorFormatter $tableErrorFormatter */
                $tableErrorFormatter = $container->getService('errorFormatter.table');
                $tableErrorFormatter->formatErrors($fixerAnalysisResult, $stdOutput);
                $stdOutput->writeLineFormatted('Please fix them first and then re-run PHPStan.');
                if ($stdOutput->isDebug()) {
                    $stdOutput->writeLineFormatted(\sprintf('hasInternalErrors: %s', $hasInternalErrors ? 'true' : 'false'));
                    $stdOutput->writeLineFormatted(\sprintf('nonIgnorableErrorsByExceptionCount: %d', \count($nonIgnorableErrorsByException)));
                }
                return $inceptionResult->handleReturn(1);
            }
            if (!$analysisResult->isResultCacheSaved() && !$onlyFiles) {
                // this can happen only if there are some regex-related errors in ignoreErrors configuration
                $stdOutput = $inceptionResult->getStdOutput();
                if (\count($analysisResult->getFileSpecificErrors()) > 0) {
                    $stdOutput->getStyle()->error('Unknown error. Please report this as a bug.');
                    return $inceptionResult->handleReturn(1);
                }
                $stdOutput->getStyle()->error('PHPStan Pro can\'t be launched because of these errors:');
                /** @var TableErrorFormatter $tableErrorFormatter */
                $tableErrorFormatter = $container->getService('errorFormatter.table');
                $tableErrorFormatter->formatErrors($analysisResult, $stdOutput);
                $stdOutput->writeLineFormatted('Please fix them first and then re-run PHPStan.');
                if ($stdOutput->isDebug()) {
                    $stdOutput->writeLineFormatted('Result cache was not saved.');
                }
                return $inceptionResult->handleReturn(1);
            }
            $inceptionResult->handleReturn(0);
            // delete memory limit file
            /** @var FixerApplication $fixerApplication */
            $fixerApplication = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Command\FixerApplication::class);
            return $fixerApplication->run($inceptionResult->getProjectConfigFile(), $inceptionResult, $input, $output, $analysisResult->getFileSpecificErrors(), $analysisResult->getNotFileSpecificErrors(), \count($files), $_SERVER['argv'][0]);
        }
        /** @var ErrorFormatter $errorFormatter */
        $errorFormatter = $container->getService($errorFormatterServiceName);
        return $inceptionResult->handleReturn($errorFormatter->formatErrors($analysisResult, $inceptionResult->getStdOutput()));
    }
    private function createStreamOutput() : \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput
    {
        $resource = \fopen('php://memory', 'w', \false);
        if ($resource === \false) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput($resource);
    }
}
