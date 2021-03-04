<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command;

use TenantCloud\BetterReflection\Relocated\Nette\Utils\Json;
use TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\DependencyDumper;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
class DumpDependenciesCommand extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command
{
    private const NAME = 'dump-deps';
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
        $this->setName(self::NAME)->setDescription('Dumps files dependency tree')->setDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('paths', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::OPTIONAL | \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Paths with source code to run dump on'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('paths-file', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to a file with a list of paths to run analysis on'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('configuration', 'c', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to project configuration file'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption(\TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorsConsoleStyle::OPTION_NO_PROGRESS, null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Do not show progress bar, only results'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('autoload-file', 'a', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Project\'s additional autoload file path'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('memory-limit', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Memory limit for the run'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('analysed-paths', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_IS_ARRAY | \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Project-scope paths'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('xdebug', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Allow running with XDebug for debugging purposes')]);
    }
    protected function execute(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        try {
            /** @var string[] $paths */
            $paths = $input->getArgument('paths');
            /** @var string|null $memoryLimit */
            $memoryLimit = $input->getOption('memory-limit');
            /** @var string|null $autoloadFile */
            $autoloadFile = $input->getOption('autoload-file');
            /** @var string|null $configurationFile */
            $configurationFile = $input->getOption('configuration');
            /** @var string|null $pathsFile */
            $pathsFile = $input->getOption('paths-file');
            /** @var bool $allowXdebug */
            $allowXdebug = $input->getOption('xdebug');
            $inceptionResult = \TenantCloud\BetterReflection\Relocated\PHPStan\Command\CommandHelper::begin(
                $input,
                $output,
                $paths,
                $pathsFile,
                $memoryLimit,
                $autoloadFile,
                $this->composerAutoloaderProjectPaths,
                $configurationFile,
                null,
                '0',
                // irrelevant but prevents an error when a config file is passed
                $allowXdebug,
                \true
            );
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\Command\InceptionNotSuccessfulException $e) {
            return 1;
        }
        try {
            [$files] = $inceptionResult->getFiles();
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\File\PathNotFoundException $e) {
            $inceptionResult->getErrorOutput()->writeLineFormatted(\sprintf('<error>%s</error>', $e->getMessage()));
            return 1;
        }
        $stdOutput = $inceptionResult->getStdOutput();
        $stdOutputStyole = $stdOutput->getStyle();
        /** @var DependencyDumper $dependencyDumper */
        $dependencyDumper = $inceptionResult->getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\DependencyDumper::class);
        /** @var FileHelper $fileHelper */
        $fileHelper = $inceptionResult->getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper::class);
        /** @var string[] $analysedPaths */
        $analysedPaths = $input->getOption('analysed-paths');
        $analysedPaths = \array_map(static function (string $path) use($fileHelper) : string {
            return $fileHelper->absolutizePath($path);
        }, $analysedPaths);
        $dependencies = $dependencyDumper->dumpDependencies($files, static function (int $count) use($stdOutputStyole) : void {
            $stdOutputStyole->progressStart($count);
        }, static function () use($stdOutputStyole) : void {
            $stdOutputStyole->progressAdvance();
        }, \count($analysedPaths) > 0 ? $analysedPaths : null);
        $stdOutputStyole->progressFinish();
        $stdOutput->writeLineFormatted(\TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::encode($dependencies, \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::PRETTY));
        return $inceptionResult->handleReturn(0);
    }
}
