<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository;
class StubSourceLocatorFactory
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Parser $parser;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpStormStubsSourceStubber;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository $optimizedSingleFileSourceLocatorRepository;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container;
    /** @var string[] */
    private array $stubFiles;
    /**
     * @param string[] $stubFiles
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Parser $parser, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpStormStubsSourceStubber, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository $optimizedSingleFileSourceLocatorRepository, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container, array $stubFiles)
    {
        $this->parser = $parser;
        $this->phpStormStubsSourceStubber = $phpStormStubsSourceStubber;
        $this->optimizedSingleFileSourceLocatorRepository = $optimizedSingleFileSourceLocatorRepository;
        $this->container = $container;
        $this->stubFiles = $stubFiles;
    }
    public function create() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator
    {
        $locators = [];
        $astLocator = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator($this->parser, function () : FunctionReflector {
            return $this->container->getService('stubFunctionReflector');
        });
        foreach ($this->stubFiles as $stubFile) {
            $locators[] = $this->optimizedSingleFileSourceLocatorRepository->getOrCreate($stubFile);
        }
        $locators[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $this->phpStormStubsSourceStubber);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators));
    }
}
