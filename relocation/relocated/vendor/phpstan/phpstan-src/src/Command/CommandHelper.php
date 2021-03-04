<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command;

use TenantCloud\BetterReflection\Relocated\Composer\XdebugHandler\XdebugHandler;
use TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Adapters\PhpAdapter;
use TenantCloud\BetterReflection\Relocated\Nette\DI\Helpers;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Context as SchemaContext;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Processor;
use TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings;
use TenantCloud\BetterReflection\Relocated\Nette\Utils\Validators;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyOutput;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyStyle;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\ContainerFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\LoaderFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\NeonAdapter;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileFinder;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleOutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
class CommandHelper
{
    public const DEFAULT_LEVEL = '0';
    /**
     * @param string[] $paths
     * @param string[] $composerAutoloaderProjectPaths
     */
    public static function begin(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output, array $paths, ?string $pathsFile, ?string $memoryLimit, ?string $autoloadFile, array $composerAutoloaderProjectPaths, ?string $projectConfigFile, ?string $generateBaselineFile, ?string $level, bool $allowXdebug, bool $manageMemoryLimitFile = \true, bool $debugEnabled = \false, ?string $singleReflectionFile = null) : \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionResult
    {
        if (!$allowXdebug) {
            $xdebug = new \TenantCloud\BetterReflection\Relocated\Composer\XdebugHandler\XdebugHandler('phpstan', '--ansi');
            $xdebug->check();
            unset($xdebug);
        }
        $stdOutput = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyOutput($output, new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyStyle(new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorsConsoleStyle($input, $output)));
        /** @var \PHPStan\Command\Output $errorOutput */
        $errorOutput = (static function () use($input, $output) : Output {
            $symfonyErrorOutput = $output instanceof \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleOutputInterface ? $output->getErrorOutput() : $output;
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyOutput($symfonyErrorOutput, new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony\SymfonyStyle(new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorsConsoleStyle($input, $symfonyErrorOutput)));
        })();
        if ($memoryLimit !== null) {
            if (\TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::match($memoryLimit, '#^-?\\d+[kMG]?$#i') === null) {
                $errorOutput->writeLineFormatted(\sprintf('Invalid memory limit format "%s".', $memoryLimit));
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
            }
            if (\ini_set('memory_limit', $memoryLimit) === \false) {
                $errorOutput->writeLineFormatted(\sprintf('Memory limit "%s" cannot be set.', $memoryLimit));
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
            }
        }
        $currentWorkingDirectory = \getcwd();
        if ($currentWorkingDirectory === \false) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $currentWorkingDirectoryFileHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper($currentWorkingDirectory);
        $currentWorkingDirectory = $currentWorkingDirectoryFileHelper->getWorkingDirectory();
        if ($autoloadFile !== null) {
            $autoloadFile = $currentWorkingDirectoryFileHelper->absolutizePath($autoloadFile);
            if (!\is_file($autoloadFile)) {
                $errorOutput->writeLineFormatted(\sprintf('Autoload file "%s" not found.', $autoloadFile));
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
            }
            (static function (string $file) : void {
                require_once $file;
            })($autoloadFile);
        }
        if ($projectConfigFile === null) {
            foreach (['phpstan.neon', 'phpstan.neon.dist'] as $discoverableConfigName) {
                $discoverableConfigFile = $currentWorkingDirectory . \DIRECTORY_SEPARATOR . $discoverableConfigName;
                if (\is_file($discoverableConfigFile)) {
                    $projectConfigFile = $discoverableConfigFile;
                    $errorOutput->writeLineFormatted(\sprintf('Note: Using configuration file %s.', $projectConfigFile));
                    break;
                }
            }
        } else {
            $projectConfigFile = $currentWorkingDirectoryFileHelper->absolutizePath($projectConfigFile);
        }
        if ($generateBaselineFile !== null) {
            $generateBaselineFile = $currentWorkingDirectoryFileHelper->normalizePath($currentWorkingDirectoryFileHelper->absolutizePath($generateBaselineFile));
        }
        $defaultLevelUsed = \false;
        if ($projectConfigFile === null && $level === null) {
            $level = self::DEFAULT_LEVEL;
            $defaultLevelUsed = \true;
        }
        $paths = \array_map(static function (string $path) use($currentWorkingDirectoryFileHelper) : string {
            return $currentWorkingDirectoryFileHelper->normalizePath($currentWorkingDirectoryFileHelper->absolutizePath($path));
        }, $paths);
        if (\count($paths) === 0 && $pathsFile !== null) {
            $pathsFile = $currentWorkingDirectoryFileHelper->absolutizePath($pathsFile);
            if (!\file_exists($pathsFile)) {
                $errorOutput->writeLineFormatted(\sprintf('Paths file %s does not exist.', $pathsFile));
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
            }
            try {
                $pathsString = \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader::read($pathsFile);
            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\File\CouldNotReadFileException $e) {
                $errorOutput->writeLineFormatted($e->getMessage());
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
            }
            $paths = \array_values(\array_filter(\explode("\n", $pathsString), static function (string $path) : bool {
                return \trim($path) !== '';
            }));
            $pathsFileFileHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper(\dirname($pathsFile));
            $paths = \array_map(static function (string $path) use($pathsFileFileHelper) : string {
                return $pathsFileFileHelper->normalizePath($pathsFileFileHelper->absolutizePath($path));
            }, $paths);
        }
        $analysedPathsFromConfig = [];
        $containerFactory = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\ContainerFactory($currentWorkingDirectory);
        $projectConfig = null;
        if ($projectConfigFile !== null) {
            if (!\is_file($projectConfigFile)) {
                $errorOutput->writeLineFormatted(\sprintf('Project config file at path %s does not exist.', $projectConfigFile));
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
            }
            $loader = (new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\LoaderFactory($currentWorkingDirectoryFileHelper, $containerFactory->getRootDirectory(), $containerFactory->getCurrentWorkingDirectory(), $generateBaselineFile))->createLoader();
            try {
                $projectConfig = $loader->load($projectConfigFile, null);
            } catch (\TenantCloud\BetterReflection\Relocated\Nette\InvalidStateException|\TenantCloud\BetterReflection\Relocated\Nette\FileNotFoundException $e) {
                $errorOutput->writeLineFormatted($e->getMessage());
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
            }
            $defaultParameters = ['rootDir' => $containerFactory->getRootDirectory(), 'currentWorkingDirectory' => $containerFactory->getCurrentWorkingDirectory()];
            if (isset($projectConfig['parameters']['tmpDir'])) {
                $tmpDir = \TenantCloud\BetterReflection\Relocated\Nette\DI\Helpers::expand($projectConfig['parameters']['tmpDir'], $defaultParameters);
            }
            if ($level === null && isset($projectConfig['parameters']['level'])) {
                $level = (string) $projectConfig['parameters']['level'];
            }
            if (\count($paths) === 0 && isset($projectConfig['parameters']['paths'])) {
                $analysedPathsFromConfig = \TenantCloud\BetterReflection\Relocated\Nette\DI\Helpers::expand($projectConfig['parameters']['paths'], $defaultParameters);
                $paths = $analysedPathsFromConfig;
            }
        }
        $additionalConfigFiles = [];
        if ($level !== null) {
            $levelConfigFile = \sprintf('%s/config.level%s.neon', $containerFactory->getConfigDirectory(), $level);
            if (!\is_file($levelConfigFile)) {
                $errorOutput->writeLineFormatted(\sprintf('Level config file %s was not found.', $levelConfigFile));
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
            }
            $additionalConfigFiles[] = $levelConfigFile;
        }
        if (\class_exists('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\ExtensionInstaller\\GeneratedConfig')) {
            $generatedConfigReflection = new \ReflectionClass('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\ExtensionInstaller\\GeneratedConfig');
            $generatedConfigDirectory = \dirname($generatedConfigReflection->getFileName());
            foreach (\TenantCloud\BetterReflection\Relocated\PHPStan\ExtensionInstaller\GeneratedConfig::EXTENSIONS as $name => $extensionConfig) {
                foreach ($extensionConfig['extra']['includes'] ?? [] as $includedFile) {
                    if (!\is_string($includedFile)) {
                        $errorOutput->writeLineFormatted(\sprintf('Cannot include config from package %s, expecting string file path but got %s', $name, \gettype($includedFile)));
                        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
                    }
                    $includedFilePath = null;
                    if (isset($extensionConfig['relative_install_path'])) {
                        $includedFilePath = \sprintf('%s/%s/%s', $generatedConfigDirectory, $extensionConfig['relative_install_path'], $includedFile);
                        if (!\file_exists($includedFilePath) || !\is_readable($includedFilePath)) {
                            $includedFilePath = null;
                        }
                    }
                    if ($includedFilePath === null) {
                        $includedFilePath = \sprintf('%s/%s', $extensionConfig['install_path'], $includedFile);
                    }
                    if (!\file_exists($includedFilePath) || !\is_readable($includedFilePath)) {
                        $errorOutput->writeLineFormatted(\sprintf('Config file %s does not exist or isn\'t readable', $includedFilePath));
                        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
                    }
                    $additionalConfigFiles[] = $includedFilePath;
                }
            }
        }
        if ($projectConfigFile !== null) {
            $additionalConfigFiles[] = $projectConfigFile;
        }
        $loaderParameters = ['rootDir' => $containerFactory->getRootDirectory(), 'currentWorkingDirectory' => $containerFactory->getCurrentWorkingDirectory()];
        self::detectDuplicateIncludedFiles($errorOutput, $currentWorkingDirectoryFileHelper, $additionalConfigFiles, $loaderParameters);
        $createDir = static function (string $path) use($errorOutput) : void {
            if (!@\mkdir($path, 0777) && !\is_dir($path)) {
                $errorOutput->writeLineFormatted(\sprintf('Cannot create a temp directory %s', $path));
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
            }
        };
        if (!isset($tmpDir)) {
            $tmpDir = \sys_get_temp_dir() . '/phpstan';
            $createDir($tmpDir);
        }
        try {
            $container = $containerFactory->create($tmpDir, $additionalConfigFiles, $paths, $composerAutoloaderProjectPaths, $analysedPathsFromConfig, $level ?? self::DEFAULT_LEVEL, $generateBaselineFile, $autoloadFile, $singleReflectionFile);
        } catch (\TenantCloud\BetterReflection\Relocated\Nette\DI\InvalidConfigurationException|\TenantCloud\BetterReflection\Relocated\Nette\Utils\AssertionException $e) {
            $errorOutput->writeLineFormatted('<error>Invalid configuration:</error>');
            $errorOutput->writeLineFormatted($e->getMessage());
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
        }
        $containerFactory->clearOldContainers($tmpDir);
        if (\count($paths) === 0) {
            $errorOutput->writeLineFormatted('At least one path must be specified to analyse.');
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
        }
        $memoryLimitFile = $container->getParameter('memoryLimitFile');
        if ($manageMemoryLimitFile && \file_exists($memoryLimitFile)) {
            $memoryLimitFileContents = \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader::read($memoryLimitFile);
            $errorOutput->writeLineFormatted('PHPStan crashed in the previous run probably because of excessive memory consumption.');
            $errorOutput->writeLineFormatted(\sprintf('It consumed around %s of memory.', $memoryLimitFileContents));
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted('To avoid this issue, allow to use more memory with the --memory-limit option.');
            @\unlink($memoryLimitFile);
        }
        self::setUpSignalHandler($errorOutput, $manageMemoryLimitFile ? $memoryLimitFile : null);
        if (!$container->hasParameter('customRulesetUsed')) {
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted('<comment>No rules detected</comment>');
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted('You have the following choices:');
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted('* while running the analyse option, use the <info>--level</info> option to adjust your rule level - the higher the stricter');
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted(\sprintf('* create your own <info>custom ruleset</info> by selecting which rules you want to check by copying the service definitions from the built-in config level files in <options=bold>%s</>.', $currentWorkingDirectoryFileHelper->normalizePath(__DIR__ . '/../../conf')));
            $errorOutput->writeLineFormatted('  * in this case, don\'t forget to define parameter <options=bold>customRulesetUsed</> in your config file.');
            $errorOutput->writeLineFormatted('');
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
        } elseif ((bool) $container->getParameter('customRulesetUsed')) {
            $defaultLevelUsed = \false;
        }
        $schema = $container->getParameter('__parametersSchema');
        $processor = new \TenantCloud\BetterReflection\Relocated\Nette\Schema\Processor();
        $processor->onNewContext[] = static function (\TenantCloud\BetterReflection\Relocated\Nette\Schema\Context $context) : void {
            $context->path = ['parameters'];
        };
        try {
            $processor->process($schema, $container->getParameters());
        } catch (\TenantCloud\BetterReflection\Relocated\Nette\Schema\ValidationException $e) {
            foreach ($e->getMessages() as $message) {
                $errorOutput->writeLineFormatted('<error>Invalid configuration:</error>');
                $errorOutput->writeLineFormatted($message);
            }
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
        }
        $autoloadFiles = $container->getParameter('autoload_files');
        if ($manageMemoryLimitFile && \count($autoloadFiles) > 0) {
            $errorOutput->writeLineFormatted('⚠️  You\'re using a deprecated config option <fg=cyan>autoload_files</>. ⚠️️');
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted('You might not need it anymore - try removing it from your');
            $errorOutput->writeLineFormatted('configuration file and run PHPStan again.');
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted('If the analysis fails, there are now two distinct options');
            $errorOutput->writeLineFormatted('to choose from to replace <fg=cyan>autoload_files</>:');
            $errorOutput->writeLineFormatted('1) <fg=cyan>scanFiles</> - PHPStan will scan those for classes and functions');
            $errorOutput->writeLineFormatted('   definitions. PHPStan will not execute those files.');
            $errorOutput->writeLineFormatted('2) <fg=cyan>bootstrapFiles</> - PHPStan will execute these files to prepare');
            $errorOutput->writeLineFormatted('   the PHP runtime environment for the analysis.');
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted('Read more about this in PHPStan\'s documentation:');
            $errorOutput->writeLineFormatted('https://phpstan.org/user-guide/discovering-symbols');
            $errorOutput->writeLineFormatted('');
        }
        $autoloadDirectories = $container->getParameter('autoload_directories');
        if (\count($autoloadDirectories) > 0 && $manageMemoryLimitFile) {
            $errorOutput->writeLineFormatted('⚠️  You\'re using a deprecated config option <fg=cyan>autoload_directories</>. ⚠️️');
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted('You might not need it anymore - try removing it from your');
            $errorOutput->writeLineFormatted('configuration file and run PHPStan again.');
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted('If the analysis fails, replace it with <fg=cyan>scanDirectories</>.');
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted('Read more about this in PHPStan\'s documentation:');
            $errorOutput->writeLineFormatted('https://phpstan.org/user-guide/discovering-symbols');
            $errorOutput->writeLineFormatted('');
        }
        foreach ($autoloadFiles as $parameterAutoloadFile) {
            if (!\file_exists($parameterAutoloadFile)) {
                $errorOutput->writeLineFormatted(\sprintf('Autoload file %s does not exist.', $parameterAutoloadFile));
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
            }
            (static function (string $file) use($container) : void {
                require_once $file;
            })($parameterAutoloadFile);
        }
        $bootstrapFile = $container->getParameter('bootstrap');
        if ($bootstrapFile !== null) {
            if ($manageMemoryLimitFile) {
                $errorOutput->writeLineFormatted('⚠️  You\'re using a deprecated config option <fg=cyan>bootstrap</>. ⚠️️');
                $errorOutput->writeLineFormatted('');
                $errorOutput->writeLineFormatted('This option has been replaced with <fg=cyan>bootstrapFiles</> which accepts a list of files');
                $errorOutput->writeLineFormatted('to execute before the analysis.');
                $errorOutput->writeLineFormatted('');
            }
            self::executeBootstrapFile($bootstrapFile, $container, $errorOutput, $debugEnabled);
        }
        foreach ($container->getParameter('bootstrapFiles') as $bootstrapFileFromArray) {
            self::executeBootstrapFile($bootstrapFileFromArray, $container, $errorOutput, $debugEnabled);
        }
        foreach ($container->getParameter('scanFiles') as $scannedFile) {
            if (\is_file($scannedFile)) {
                continue;
            }
            $errorOutput->writeLineFormatted(\sprintf('Scanned file %s does not exist.', $scannedFile));
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
        }
        foreach ($container->getParameter('scanDirectories') as $scannedDirectory) {
            if (\is_dir($scannedDirectory)) {
                continue;
            }
            $errorOutput->writeLineFormatted(\sprintf('Scanned directory %s does not exist.', $scannedDirectory));
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
        }
        $alreadyAddedStubFiles = [];
        foreach ($container->getParameter('stubFiles') as $stubFile) {
            if ($container->getParameter('featureToggles')['detectDuplicateStubFiles'] && \array_key_exists($stubFile, $alreadyAddedStubFiles)) {
                $errorOutput->writeLineFormatted(\sprintf('Stub file %s is added multiple times.', $stubFile));
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
            }
            $alreadyAddedStubFiles[$stubFile] = \true;
            if (\is_file($stubFile)) {
                continue;
            }
            $errorOutput->writeLineFormatted(\sprintf('Stub file %s does not exist.', $stubFile));
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
        }
        $excludesAnalyse = $container->getParameter('excludes_analyse');
        $excludePaths = $container->getParameter('excludePaths');
        if (\count($excludesAnalyse) > 0 && $excludePaths !== null) {
            $errorOutput->writeLineFormatted(\sprintf('Configuration parameters <fg=cyan>excludes_analyse</> and <fg=cyan>excludePaths</> cannot be used at the same time.'));
            $errorOutput->writeLineFormatted('');
            $errorOutput->writeLineFormatted(\sprintf('Parameter <fg=cyan>excludes_analyse</> has been deprecated so use <fg=cyan>excludePaths</> only from now on.'));
            $errorOutput->writeLineFormatted('');
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
        }
        $tempResultCachePath = $container->getParameter('tempResultCachePath');
        $createDir($tempResultCachePath);
        /** @var FileFinder $fileFinder */
        $fileFinder = $container->getService('fileFinderAnalyse');
        /** @var \Closure(): (array{string[], bool}) $filesCallback */
        $filesCallback = static function () use($fileFinder, $paths) : array {
            $fileFinderResult = $fileFinder->findFiles($paths);
            return [$fileFinderResult->getFiles(), $fileFinderResult->isOnlyFiles()];
        };
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionResult($filesCallback, $stdOutput, $errorOutput, $container, $defaultLevelUsed, $memoryLimitFile, $projectConfigFile, $projectConfig, $generateBaselineFile);
    }
    private static function executeBootstrapFile(string $file, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container, \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $errorOutput, bool $debugEnabled) : void
    {
        if (!\is_file($file)) {
            $errorOutput->writeLineFormatted(\sprintf('Bootstrap file %s does not exist.', $file));
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
        }
        try {
            (static function (string $file) use($container) : void {
                require_once $file;
            })($file);
        } catch (\Throwable $e) {
            $errorOutput->writeLineFormatted(\sprintf('%s thrown in %s on line %d while loading bootstrap file %s: %s', \get_class($e), $e->getFile(), $e->getLine(), $file, $e->getMessage()));
            if ($debugEnabled) {
                $errorOutput->writeLineFormatted($e->getTraceAsString());
            }
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
        }
    }
    private static function setUpSignalHandler(\TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $output, ?string $memoryLimitFile) : void
    {
        if (!\function_exists('pcntl_signal')) {
            return;
        }
        \pcntl_async_signals(\true);
        \pcntl_signal(\SIGINT, static function () use($output, $memoryLimitFile) : void {
            if ($memoryLimitFile !== null && \file_exists($memoryLimitFile)) {
                @\unlink($memoryLimitFile);
            }
            $output->writeLineFormatted('');
            exit(1);
        });
    }
    /**
     * @param \PHPStan\Command\Output $output
     * @param \PHPStan\File\FileHelper $fileHelper
     * @param string[] $configFiles
     * @param array<string, string> $loaderParameters
     * @throws \PHPStan\Command\InceptionNotSuccessfulException
     */
    private static function detectDuplicateIncludedFiles(\TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $output, \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper, array $configFiles, array $loaderParameters) : void
    {
        $neonAdapter = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\NeonAdapter();
        $phpAdapter = new \TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Adapters\PhpAdapter();
        $allConfigFiles = [];
        foreach ($configFiles as $configFile) {
            $allConfigFiles = \array_merge($allConfigFiles, self::getConfigFiles($fileHelper, $neonAdapter, $phpAdapter, $configFile, $loaderParameters, null));
        }
        $normalized = \array_map(static function (string $file) use($fileHelper) : string {
            return $fileHelper->normalizePath($file);
        }, $allConfigFiles);
        $deduplicated = \array_unique($normalized);
        if (\count($normalized) <= \count($deduplicated)) {
            return;
        }
        $duplicateFiles = \array_unique(\array_diff_key($normalized, $deduplicated));
        $format = "<error>These files are included multiple times:</error>\n- %s";
        if (\count($duplicateFiles) === 1) {
            $format = "<error>This file is included multiple times:</error>\n- %s";
        }
        $output->writeLineFormatted(\sprintf($format, \implode("\n- ", $duplicateFiles)));
        if (\class_exists('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\ExtensionInstaller\\GeneratedConfig')) {
            $output->writeLineFormatted('');
            $output->writeLineFormatted('It can lead to unexpected results. If you\'re using phpstan/extension-installer, make sure you have removed corresponding neon files from your project config file.');
        }
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException();
    }
    /**
     * @param \PHPStan\DependencyInjection\NeonAdapter $neonAdapter
     * @param \Nette\DI\Config\Adapters\PhpAdapter $phpAdapter
     * @param string $configFile
     * @param array<string, string> $loaderParameters
     * @param string|null $generateBaselineFile
     * @return string[]
     */
    private static function getConfigFiles(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\NeonAdapter $neonAdapter, \TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Adapters\PhpAdapter $phpAdapter, string $configFile, array $loaderParameters, ?string $generateBaselineFile) : array
    {
        if ($generateBaselineFile === $fileHelper->normalizePath($configFile)) {
            return [];
        }
        if (!\is_file($configFile) || !\is_readable($configFile)) {
            return [];
        }
        if (\TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::endsWith($configFile, '.php')) {
            $data = $phpAdapter->load($configFile);
        } else {
            $data = $neonAdapter->load($configFile);
        }
        $allConfigFiles = [$configFile];
        if (isset($data['includes'])) {
            \TenantCloud\BetterReflection\Relocated\Nette\Utils\Validators::assert($data['includes'], 'list', \sprintf("section 'includes' in file '%s'", $configFile));
            $includes = \TenantCloud\BetterReflection\Relocated\Nette\DI\Helpers::expand($data['includes'], $loaderParameters);
            foreach ($includes as $include) {
                $include = self::expandIncludedFile($include, $configFile);
                $allConfigFiles = \array_merge($allConfigFiles, self::getConfigFiles($fileHelper, $neonAdapter, $phpAdapter, $include, $loaderParameters, $generateBaselineFile));
            }
        }
        return $allConfigFiles;
    }
    private static function expandIncludedFile(string $includedFile, string $mainFile) : string
    {
        return \TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::match($includedFile, '#([a-z]+:)?[/\\\\]#Ai') !== null ? $includedFile : \dirname($mainFile) . '/' . $includedFile;
    }
}
