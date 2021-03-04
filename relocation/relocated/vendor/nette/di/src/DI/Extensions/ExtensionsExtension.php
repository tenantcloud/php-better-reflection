<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\DI\Extensions;

use TenantCloud\BetterReflection\Relocated\Nette;
/**
 * Enables registration of other extensions in $config file
 */
final class ExtensionsExtension extends \TenantCloud\BetterReflection\Relocated\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
    {
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::arrayOf('string|TenantCloud\\BetterReflection\\Relocated\\Nette\\DI\\Definitions\\Statement');
    }
    public function loadConfiguration()
    {
        foreach ($this->getConfig() as $name => $class) {
            if (\is_int($name)) {
                $name = null;
            }
            $args = [];
            if ($class instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement) {
                [$class, $args] = [$class->getEntity(), $class->arguments];
            }
            if (!\is_a($class, \TenantCloud\BetterReflection\Relocated\Nette\DI\CompilerExtension::class, \true)) {
                throw new \TenantCloud\BetterReflection\Relocated\Nette\DI\InvalidConfigurationException("Extension '{$class}' not found or is not Nette\\DI\\CompilerExtension descendant.");
            }
            $this->compiler->addExtension($name, (new \ReflectionClass($class))->newInstanceArgs($args));
        }
    }
}
