<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\DI\Extensions;

use TenantCloud\BetterReflection\Relocated\Nette;
use TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect;
/**
 * Decorators for services.
 */
final class DecoratorExtension extends \TenantCloud\BetterReflection\Relocated\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
    {
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::arrayOf(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::structure(['setup' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::list(), 'tags' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array(), 'inject' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::bool()]));
    }
    public function beforeCompile()
    {
        $this->getContainerBuilder()->resolve();
        foreach ($this->config as $type => $info) {
            if (!\class_exists($type) && !\interface_exists($type)) {
                throw new \TenantCloud\BetterReflection\Relocated\Nette\DI\InvalidConfigurationException("Decorated class '{$type}' not found.");
            }
            if ($info->inject !== null) {
                $info->tags[\TenantCloud\BetterReflection\Relocated\Nette\DI\Extensions\InjectExtension::TAG_INJECT] = $info->inject;
            }
            $this->addSetups($type, \TenantCloud\BetterReflection\Relocated\Nette\DI\Helpers::filterArguments($info->setup));
            $this->addTags($type, \TenantCloud\BetterReflection\Relocated\Nette\DI\Helpers::filterArguments($info->tags));
        }
    }
    public function addSetups(string $type, array $setups) : void
    {
        foreach ($this->findByType($type) as $def) {
            if ($def instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\FactoryDefinition) {
                $def = $def->getResultDefinition();
            }
            foreach ($setups as $setup) {
                if (\is_array($setup)) {
                    $setup = new \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement(\key($setup), \array_values($setup));
                }
                $def->addSetup($setup);
            }
        }
    }
    public function addTags(string $type, array $tags) : void
    {
        $tags = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Arrays::normalize($tags, \true);
        foreach ($this->findByType($type) as $def) {
            $def->setTags($def->getTags() + $tags);
        }
    }
    private function findByType(string $type) : array
    {
        return \array_filter($this->getContainerBuilder()->getDefinitions(), function (\TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Definition $def) use($type) : bool {
            return \is_a($def->getType(), $type, \true) || $def instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\FactoryDefinition && \is_a($def->getResultType(), $type, \true);
        });
    }
}
