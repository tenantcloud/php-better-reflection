<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection;

use TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RegistryFactory;
class RulesExtension extends \TenantCloud\BetterReflection\Relocated\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
    {
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::listOf('string');
    }
    public function loadConfiguration() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $builder = $this->getContainerBuilder();
        foreach ($config as $key => $rule) {
            $builder->addDefinition($this->prefix((string) $key))->setFactory($rule)->setAutowired(\false)->addTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RegistryFactory::RULE_TAG);
        }
    }
}
