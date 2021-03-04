<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\DI\Extensions;

use TenantCloud\BetterReflection\Relocated\Nette;
use TenantCloud\BetterReflection\Relocated\Nette\Loaders\RobotLoader;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect;
use TenantCloud\BetterReflection\Relocated\Nette\Utils\Arrays;
/**
 * Services auto-discovery.
 */
final class SearchExtension extends \TenantCloud\BetterReflection\Relocated\Nette\DI\CompilerExtension
{
    /** @var array */
    private $classes = [];
    /** @var string */
    private $tempDir;
    public function __construct(string $tempDir)
    {
        $this->tempDir = $tempDir;
    }
    public function getConfigSchema() : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
    {
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::arrayOf(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::structure(['in' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string()->required(), 'files' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::anyOf(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::listOf('string'), \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string()->castTo('array'))->default([]), 'classes' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::anyOf(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::listOf('string'), \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string()->castTo('array'))->default([]), 'extends' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::anyOf(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::listOf('string'), \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string()->castTo('array'))->default([]), 'implements' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::anyOf(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::listOf('string'), \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string()->castTo('array'))->default([]), 'exclude' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::structure(['classes' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::anyOf(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::listOf('string'), \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string()->castTo('array'))->default([]), 'extends' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::anyOf(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::listOf('string'), \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string()->castTo('array'))->default([]), 'implements' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::anyOf(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::listOf('string'), \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::string()->castTo('array'))->default([])]), 'tags' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::array()]))->before(function ($val) {
            return \is_string($val['in'] ?? null) ? ['default' => $val] : $val;
        });
    }
    public function loadConfiguration()
    {
        foreach (\array_filter($this->config) as $name => $batch) {
            if (!\is_dir($batch->in)) {
                throw new \TenantCloud\BetterReflection\Relocated\Nette\DI\InvalidConfigurationException("Option '{$this->name} › {$name} › in' must be valid directory name, '{$batch->in}' given.");
            }
            foreach ($this->findClasses($batch) as $class) {
                $this->classes[$class] = \array_merge($this->classes[$class] ?? [], $batch->tags);
            }
        }
    }
    public function findClasses(\stdClass $config) : array
    {
        $robot = new \TenantCloud\BetterReflection\Relocated\Nette\Loaders\RobotLoader();
        $robot->setTempDirectory($this->tempDir);
        $robot->addDirectory($config->in);
        $robot->acceptFiles = $config->files ?: ['*.php'];
        $robot->reportParseErrors(\false);
        $robot->refresh();
        $classes = \array_unique(\array_keys($robot->getIndexedClasses()));
        $exclude = $config->exclude;
        $acceptRE = self::buildNameRegexp($config->classes);
        $rejectRE = self::buildNameRegexp($exclude->classes);
        $acceptParent = \array_merge($config->extends, $config->implements);
        $rejectParent = \array_merge($exclude->extends, $exclude->implements);
        $found = [];
        foreach ($classes as $class) {
            if (!\class_exists($class) && !\interface_exists($class) && !\trait_exists($class)) {
                throw new \TenantCloud\BetterReflection\Relocated\Nette\InvalidStateException("Class {$class} was found, but it cannot be loaded by autoloading.");
            }
            $rc = new \ReflectionClass($class);
            if (($rc->isInstantiable() || $rc->isInterface() && \count($methods = $rc->getMethods()) === 1 && $methods[0]->name === 'create') && (!$acceptRE || \preg_match($acceptRE, $rc->name)) && (!$rejectRE || !\preg_match($rejectRE, $rc->name)) && (!$acceptParent || \TenantCloud\BetterReflection\Relocated\Nette\Utils\Arrays::some($acceptParent, function ($nm) use($rc) {
                return $rc->isSubclassOf($nm);
            })) && (!$rejectParent || \TenantCloud\BetterReflection\Relocated\Nette\Utils\Arrays::every($rejectParent, function ($nm) use($rc) {
                return !$rc->isSubclassOf($nm);
            }))) {
                $found[] = $rc->name;
            }
        }
        return $found;
    }
    public function beforeCompile()
    {
        $builder = $this->getContainerBuilder();
        foreach ($this->classes as $class => $foo) {
            if ($builder->findByType($class)) {
                unset($this->classes[$class]);
            }
        }
        foreach ($this->classes as $class => $tags) {
            $def = \class_exists($class) ? $builder->addDefinition(null)->setType($class) : $builder->addFactoryDefinition(null)->setImplement($class);
            $def->setTags(\TenantCloud\BetterReflection\Relocated\Nette\Utils\Arrays::normalize($tags, \true));
        }
    }
    private static function buildNameRegexp(array $masks) : ?string
    {
        $res = [];
        foreach ((array) $masks as $mask) {
            $mask = (\strpos($mask, '\\') === \false ? '**\\' : '') . $mask;
            $mask = \preg_quote($mask, '#');
            $mask = \str_replace('\\*\\*\\\\', '(.*\\\\)?', $mask);
            $mask = \str_replace('\\\\\\*\\*', '(\\\\.*)?', $mask);
            $mask = \str_replace('\\*', '\\w*', $mask);
            $res[] = $mask;
        }
        return $res ? '#^(' . \implode('|', $res) . ')$#i' : null;
    }
}
