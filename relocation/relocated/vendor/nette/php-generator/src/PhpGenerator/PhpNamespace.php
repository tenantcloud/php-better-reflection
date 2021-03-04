<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator;

use TenantCloud\BetterReflection\Relocated\Nette;
use TenantCloud\BetterReflection\Relocated\Nette\InvalidStateException;
use TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings;
/**
 * Namespaced part of a PHP file.
 *
 * Generates:
 * - namespace statement
 * - variable amount of use statements
 * - one or more class declarations
 */
final class PhpNamespace
{
    use Nette\SmartObject;
    private const KEYWORDS = ['string' => 1, 'int' => 1, 'float' => 1, 'bool' => 1, 'array' => 1, 'object' => 1, 'callable' => 1, 'iterable' => 1, 'void' => 1, 'self' => 1, 'parent' => 1, 'static' => 1, 'mixed' => 1, 'null' => 1, 'false' => 1];
    /** @var string */
    private $name;
    /** @var bool */
    private $bracketedSyntax = \false;
    /** @var string[] */
    private $uses = [];
    /** @var ClassType[] */
    private $classes = [];
    public function __construct(string $name)
    {
        if ($name !== '' && !\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::isNamespaceIdentifier($name)) {
            throw new \TenantCloud\BetterReflection\Relocated\Nette\InvalidArgumentException("Value '{$name}' is not valid name.");
        }
        $this->name = $name;
    }
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * @return static
     * @internal
     */
    public function setBracketedSyntax(bool $state = \true) : self
    {
        $this->bracketedSyntax = $state;
        return $this;
    }
    public function hasBracketedSyntax() : bool
    {
        return $this->bracketedSyntax;
    }
    /** @deprecated  use hasBracketedSyntax() */
    public function getBracketedSyntax() : bool
    {
        return $this->bracketedSyntax;
    }
    /**
     * @throws InvalidStateException
     * @return static
     */
    public function addUse(string $name, string $alias = null, string &$aliasOut = null) : self
    {
        $name = \ltrim($name, '\\');
        if ($alias === null && $this->name === \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::extractNamespace($name)) {
            $alias = \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::extractShortName($name);
        }
        if ($alias === null) {
            $path = \explode('\\', $name);
            $counter = null;
            do {
                if (empty($path)) {
                    $counter++;
                } else {
                    $alias = \array_pop($path) . $alias;
                }
            } while (isset($this->uses[$alias . $counter]) && $this->uses[$alias . $counter] !== $name);
            $alias .= $counter;
        } elseif (isset($this->uses[$alias]) && $this->uses[$alias] !== $name) {
            throw new \TenantCloud\BetterReflection\Relocated\Nette\InvalidStateException("Alias '{$alias}' used already for '{$this->uses[$alias]}', cannot use for '{$name}'.");
        }
        $aliasOut = $alias;
        $this->uses[$alias] = $name;
        \asort($this->uses);
        return $this;
    }
    /** @return string[] */
    public function getUses() : array
    {
        return $this->uses;
    }
    public function unresolveUnionType(string $type) : string
    {
        return \implode('|', \array_map([$this, 'unresolveName'], \explode('|', $type)));
    }
    public function unresolveName(string $name) : string
    {
        if (isset(self::KEYWORDS[\strtolower($name)]) || $name === '') {
            return $name;
        }
        $name = \ltrim($name, '\\');
        $res = null;
        $lower = \strtolower($name);
        foreach ($this->uses as $alias => $original) {
            if (\TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::startsWith($lower . '\\', \strtolower($original) . '\\')) {
                $short = $alias . \substr($name, \strlen($original));
                if (!isset($res) || \strlen($res) > \strlen($short)) {
                    $res = $short;
                }
            }
        }
        if (!$res && \TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::startsWith($lower, \strtolower($this->name) . '\\')) {
            return \substr($name, \strlen($this->name) + 1);
        } else {
            return $res ?: ($this->name ? '\\' : '') . $name;
        }
    }
    /** @return static */
    public function add(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType $class) : self
    {
        $name = $class->getName();
        if ($name === null) {
            throw new \TenantCloud\BetterReflection\Relocated\Nette\InvalidArgumentException('Class does not have a name.');
        }
        $this->addUse($this->name . '\\' . $name);
        $this->classes[$name] = $class;
        return $this;
    }
    public function addClass(string $name) : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType
    {
        $this->add($class = new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType($name, $this));
        return $class;
    }
    public function addInterface(string $name) : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType
    {
        return $this->addClass($name)->setInterface();
    }
    public function addTrait(string $name) : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType
    {
        return $this->addClass($name)->setTrait();
    }
    /** @return ClassType[] */
    public function getClasses() : array
    {
        return $this->classes;
    }
    public function __toString() : string
    {
        try {
            return (new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Printer())->printNamespace($this);
        } catch (\Throwable $e) {
            if (\PHP_VERSION_ID >= 70400) {
                throw $e;
            }
            \trigger_error('Exception in ' . __METHOD__ . "(): {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}", \E_USER_ERROR);
            return '';
        }
    }
}
