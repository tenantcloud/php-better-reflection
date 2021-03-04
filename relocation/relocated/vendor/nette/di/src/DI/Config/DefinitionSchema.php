<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\DI\Config;

use TenantCloud\BetterReflection\Relocated\Nette;
use TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions;
use TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Context;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema;
/**
 * Service configuration schema.
 */
class DefinitionSchema implements \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
{
    use Nette\SmartObject;
    /** @var Nette\DI\ContainerBuilder */
    private $builder;
    public function __construct(\TenantCloud\BetterReflection\Relocated\Nette\DI\ContainerBuilder $builder)
    {
        $this->builder = $builder;
    }
    public function complete($def, \TenantCloud\BetterReflection\Relocated\Nette\Schema\Context $context)
    {
        if ($def === [\false]) {
            return (object) $def;
        }
        if (\TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Helpers::takeParent($def)) {
            $def['reset']['all'] = \true;
        }
        foreach (['arguments', 'setup', 'tags'] as $k) {
            if (isset($def[$k]) && \TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Helpers::takeParent($def[$k])) {
                $def['reset'][$k] = \true;
            }
        }
        $def = $this->expandParameters($def);
        $type = $this->sniffType(\end($context->path), $def);
        $def = $this->getSchema($type)->complete($def, $context);
        if ($def) {
            $def->defType = $type;
        }
        return $def;
    }
    public function merge($def, $base)
    {
        if (!empty($def['alteration'])) {
            unset($def['alteration']);
        }
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Helpers::merge($def, $base);
    }
    /**
     * Normalizes configuration of service definitions.
     */
    public function normalize($def, \TenantCloud\BetterReflection\Relocated\Nette\Schema\Context $context)
    {
        if ($def === null || $def === \false) {
            return (array) $def;
        } elseif (\is_string($def) && \interface_exists($def)) {
            return ['implement' => $def];
        } elseif ($def instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement && \is_string($def->getEntity()) && \interface_exists($def->getEntity())) {
            $res = ['implement' => $def->getEntity()];
            if (\array_keys($def->arguments) === ['tagged']) {
                $res += $def->arguments;
            } elseif (\count($def->arguments) > 1) {
                $res['references'] = $def->arguments;
            } elseif ($factory = \array_shift($def->arguments)) {
                $res['factory'] = $factory;
            }
            return $res;
        } elseif (!\is_array($def) || isset($def[0], $def[1])) {
            return ['factory' => $def];
        } elseif (\is_array($def)) {
            if (isset($def['class']) && !isset($def['type'])) {
                if ($def['class'] instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement) {
                    $key = \end($context->path);
                    \trigger_error("Service '{$key}': option 'class' should be changed to 'factory'.", \E_USER_DEPRECATED);
                    $def['factory'] = $def['class'];
                    unset($def['class']);
                } elseif (!isset($def['factory']) && !isset($def['dynamic']) && !isset($def['imported'])) {
                    $def['factory'] = $def['class'];
                    unset($def['class']);
                }
            }
            foreach (['class' => 'type', 'dynamic' => 'imported'] as $alias => $original) {
                if (\array_key_exists($alias, $def)) {
                    if (\array_key_exists($original, $def)) {
                        throw new \TenantCloud\BetterReflection\Relocated\Nette\DI\InvalidConfigurationException("Options '{$alias}' and '{$original}' are aliases, use only '{$original}'.");
                    }
                    $def[$original] = $def[$alias];
                    unset($def[$alias]);
                }
            }
            return $def;
        } else {
            throw new \TenantCloud\BetterReflection\Relocated\Nette\DI\InvalidConfigurationException('Unexpected format of service definition');
        }
    }
    public function completeDefault(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Context $context)
    {
    }
    private function sniffType($key, array $def) : string
    {
        if (\is_string($key)) {
            $name = \preg_match('#^@[\\w\\\\]+$#D', $key) ? $this->builder->getByType(\substr($key, 1), \false) : $key;
            if ($name && $this->builder->hasDefinition($name)) {
                return \get_class($this->builder->getDefinition($name));
            }
        }
        if (isset($def['implement'], $def['references']) || isset($def['implement'], $def['tagged'])) {
            return \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\LocatorDefinition::class;
        } elseif (isset($def['implement'])) {
            return \method_exists($def['implement'], 'create') ? \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\FactoryDefinition::class : \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\AccessorDefinition::class;
        } elseif (isset($def['imported'])) {
            return \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\ImportedDefinition::class;
        } else {
            return \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\ServiceDefinition::class;
        }
    }
    private function expandParameters(array $config) : array
    {
        $params = $this->builder->parameters;
        if (isset($config['parameters'])) {
            foreach ((array) $config['parameters'] as $k => $v) {
                $v = \explode(' ', \is_int($k) ? $v : $k);
                $params[\end($v)] = $this->builder::literal('$' . \end($v));
            }
        }
        return \TenantCloud\BetterReflection\Relocated\Nette\DI\Helpers::expand($config, $params);
    }
    private static function getSchema(string $type) : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
    {
        static $cache;
        $cache = $cache ?: [\TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\ServiceDefinition::class => self::getServiceSchema(), \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\AccessorDefinition::class => self::getAccessorSchema(), \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\FactoryDefinition::class => self::getFactorySchema(), \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\LocatorDefinition::class => self::getLocatorSchema(), \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\ImportedDefinition::class => self::getImportedSchema()];
        return $cache[$type];
    }
    private static function getServiceSchema() : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
    {
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::structure(['type' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::type('string'), 'factory' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::type('callable|TenantCloud\\BetterReflection\\Relocated\\Nette\\DI\\Definitions\\Statement'), 'arguments' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array(), 'setup' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::listOf('callable|TenantCloud\\BetterReflection\\Relocated\\Nette\\DI\\Definitions\\Statement|array:1'), 'inject' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::bool(), 'autowired' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array(), 'reset' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array(), 'alteration' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::bool()]);
    }
    private static function getAccessorSchema() : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
    {
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::structure(['type' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string(), 'implement' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string(), 'factory' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::type('callable|TenantCloud\\BetterReflection\\Relocated\\Nette\\DI\\Definitions\\Statement'), 'autowired' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array()]);
    }
    private static function getFactorySchema() : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
    {
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::structure(['type' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string(), 'factory' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::type('callable|TenantCloud\\BetterReflection\\Relocated\\Nette\\DI\\Definitions\\Statement'), 'implement' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string(), 'arguments' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array(), 'setup' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::listOf('callable|TenantCloud\\BetterReflection\\Relocated\\Nette\\DI\\Definitions\\Statement|array:1'), 'parameters' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array(), 'references' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array(), 'tagged' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string(), 'inject' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::bool(), 'autowired' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array(), 'reset' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array()]);
    }
    private static function getLocatorSchema() : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
    {
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::structure(['implement' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string(), 'references' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array(), 'tagged' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string(), 'autowired' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array()]);
    }
    private static function getImportedSchema() : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
    {
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::structure(['type' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string(), 'imported' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::bool(), 'autowired' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array()]);
    }
}
