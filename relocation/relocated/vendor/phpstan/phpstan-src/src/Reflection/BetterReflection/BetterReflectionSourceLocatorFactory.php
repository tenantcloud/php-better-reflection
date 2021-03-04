<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\ClassBlacklistSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\ClassWhitelistSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorRepository;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\PhpVersionBlacklistSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\SkipClassAliasSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\SourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator;
class BetterReflectionSourceLocatorFactory
{
    /** @var \PhpParser\Parser */
    private $parser;
    /** @var \PhpParser\Parser */
    private $php8Parser;
    /** @var PhpStormStubsSourceStubber */
    private $phpstormStubsSourceStubber;
    /** @var ReflectionSourceStubber */
    private $reflectionSourceStubber;
    /** @var \PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository */
    private $optimizedSingleFileSourceLocatorRepository;
    /** @var \PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorRepository */
    private $optimizedDirectorySourceLocatorRepository;
    /** @var ComposerJsonAndInstalledJsonSourceLocatorMaker */
    private $composerJsonAndInstalledJsonSourceLocatorMaker;
    /** @var AutoloadSourceLocator */
    private $autoloadSourceLocator;
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var string[] */
    private $autoloadDirectories;
    /** @var string[] */
    private $autoloadFiles;
    /** @var string[] */
    private $scanFiles;
    /** @var string[] */
    private $scanDirectories;
    /** @var string[] */
    private $analysedPaths;
    /** @var string[] */
    private $composerAutoloaderProjectPaths;
    /** @var string[] */
    private $analysedPathsFromConfig;
    /** @var string|null */
    private $singleReflectionFile;
    /** @var string[] */
    private array $staticReflectionClassNamePatterns;
    /**
     * @param string[] $autoloadDirectories
     * @param string[] $autoloadFiles
     * @param string[] $scanFiles
     * @param string[] $scanDirectories
     * @param string[] $analysedPaths
     * @param string[] $composerAutoloaderProjectPaths
     * @param string[] $analysedPathsFromConfig
     * @param string|null $singleReflectionFile,
     * @param string[] $staticReflectionClassNamePatterns
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Parser $parser, \TenantCloud\BetterReflection\Relocated\PhpParser\Parser $php8Parser, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpstormStubsSourceStubber, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber $reflectionSourceStubber, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository $optimizedSingleFileSourceLocatorRepository, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorRepository $optimizedDirectorySourceLocatorRepository, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker $composerJsonAndInstalledJsonSourceLocatorMaker, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator $autoloadSourceLocator, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container, array $autoloadDirectories, array $autoloadFiles, array $scanFiles, array $scanDirectories, array $analysedPaths, array $composerAutoloaderProjectPaths, array $analysedPathsFromConfig, ?string $singleReflectionFile, array $staticReflectionClassNamePatterns)
    {
        $this->parser = $parser;
        $this->php8Parser = $php8Parser;
        $this->phpstormStubsSourceStubber = $phpstormStubsSourceStubber;
        $this->reflectionSourceStubber = $reflectionSourceStubber;
        $this->optimizedSingleFileSourceLocatorRepository = $optimizedSingleFileSourceLocatorRepository;
        $this->optimizedDirectorySourceLocatorRepository = $optimizedDirectorySourceLocatorRepository;
        $this->composerJsonAndInstalledJsonSourceLocatorMaker = $composerJsonAndInstalledJsonSourceLocatorMaker;
        $this->autoloadSourceLocator = $autoloadSourceLocator;
        $this->container = $container;
        $this->autoloadDirectories = $autoloadDirectories;
        $this->autoloadFiles = $autoloadFiles;
        $this->scanFiles = $scanFiles;
        $this->scanDirectories = $scanDirectories;
        $this->analysedPaths = $analysedPaths;
        $this->composerAutoloaderProjectPaths = $composerAutoloaderProjectPaths;
        $this->analysedPathsFromConfig = $analysedPathsFromConfig;
        $this->singleReflectionFile = $singleReflectionFile;
        $this->staticReflectionClassNamePatterns = $staticReflectionClassNamePatterns;
    }
    public function create() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator
    {
        $locators = [];
        if ($this->singleReflectionFile !== null) {
            $locators[] = $this->optimizedSingleFileSourceLocatorRepository->getOrCreate($this->singleReflectionFile);
        }
        $analysedDirectories = [];
        $analysedFiles = [];
        foreach (\array_merge($this->analysedPaths, $this->analysedPathsFromConfig) as $analysedPath) {
            if (\is_file($analysedPath)) {
                $analysedFiles[] = $analysedPath;
                continue;
            }
            if (!\is_dir($analysedPath)) {
                continue;
            }
            $analysedDirectories[] = $analysedPath;
        }
        $analysedFiles = \array_unique(\array_merge($analysedFiles, $this->autoloadFiles, $this->scanFiles));
        foreach ($analysedFiles as $analysedFile) {
            $locators[] = $this->optimizedSingleFileSourceLocatorRepository->getOrCreate($analysedFile);
        }
        $directories = \array_unique(\array_merge($analysedDirectories, $this->autoloadDirectories, $this->scanDirectories));
        foreach ($directories as $directory) {
            $locators[] = $this->optimizedDirectorySourceLocatorRepository->getOrCreate($directory);
        }
        $astLocator = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator($this->parser, function () : FunctionReflector {
            return $this->container->getService('betterReflectionFunctionReflector');
        });
        $astPhp8Locator = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator($this->php8Parser, function () : FunctionReflector {
            return $this->container->getService('betterReflectionFunctionReflector');
        });
        $locators[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\SkipClassAliasSourceLocator(new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astPhp8Locator, $this->phpstormStubsSourceStubber));
        $locators[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\ClassBlacklistSourceLocator($this->autoloadSourceLocator, $this->staticReflectionClassNamePatterns);
        foreach ($this->composerAutoloaderProjectPaths as $composerAutoloaderProjectPath) {
            $locator = $this->composerJsonAndInstalledJsonSourceLocatorMaker->create($composerAutoloaderProjectPath);
            if ($locator === null) {
                continue;
            }
            $locators[] = $locator;
        }
        $locators[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\ClassWhitelistSourceLocator($this->autoloadSourceLocator, $this->staticReflectionClassNamePatterns);
        $locators[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\PhpVersionBlacklistSourceLocator(new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $this->reflectionSourceStubber), $this->phpstormStubsSourceStubber);
        $locators[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\PhpVersionBlacklistSourceLocator(new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator($astLocator, $this->reflectionSourceStubber), $this->phpstormStubsSourceStubber);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators));
    }
}
