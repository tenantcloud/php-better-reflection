<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator;

class OptimizedDirectorySourceLocatorRepository
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorFactory $factory;
    /** @var array<string, OptimizedDirectorySourceLocator> */
    private array $locators = [];
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorFactory $factory)
    {
        $this->factory = $factory;
    }
    public function getOrCreate(string $directory) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocator
    {
        if (\array_key_exists($directory, $this->locators)) {
            return $this->locators[$directory];
        }
        $this->locators[$directory] = $this->factory->createByDirectory($directory);
        return $this->locators[$directory];
    }
}
