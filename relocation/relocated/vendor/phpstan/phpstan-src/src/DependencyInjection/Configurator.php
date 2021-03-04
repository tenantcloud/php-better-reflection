<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection;

use TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Loader;
use TenantCloud\BetterReflection\Relocated\Nette\DI\ContainerLoader;
class Configurator extends \TenantCloud\BetterReflection\Relocated\Nette\Configurator
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\LoaderFactory $loaderFactory;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\LoaderFactory $loaderFactory)
    {
        $this->loaderFactory = $loaderFactory;
        parent::__construct();
    }
    protected function createLoader() : \TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Loader
    {
        return $this->loaderFactory->createLoader();
    }
    /**
     * @return mixed[]
     */
    protected function getDefaultParameters() : array
    {
        return [];
    }
    public function getContainerCacheDirectory() : string
    {
        return $this->getCacheDirectory() . '/nette.configurator';
    }
    public function loadContainer() : string
    {
        $loader = new \TenantCloud\BetterReflection\Relocated\Nette\DI\ContainerLoader($this->getContainerCacheDirectory(), $this->parameters['debugMode']);
        return $loader->load([$this, 'generateContainer'], [$this->parameters, \array_keys($this->dynamicParameters), $this->configs, \PHP_VERSION_ID - \PHP_RELEASE_VERSION, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\NeonAdapter::CACHE_KEY]);
    }
}
