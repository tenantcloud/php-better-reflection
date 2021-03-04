<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator;

use TenantCloud\BetterReflection\Relocated\Nette;
/**
 * Instance of PHP file.
 *
 * Generates:
 * - opening tag (<?php)
 * - doc comments
 * - one or more namespaces
 */
final class PhpFile
{
    use Nette\SmartObject;
    use Traits\CommentAware;
    /** @var PhpNamespace[] */
    private $namespaces = [];
    /** @var bool */
    private $strictTypes = \false;
    public function addClass(string $name) : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType
    {
        return $this->addNamespace(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::extractNamespace($name))->addClass(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::extractShortName($name));
    }
    public function addInterface(string $name) : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType
    {
        return $this->addNamespace(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::extractNamespace($name))->addInterface(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::extractShortName($name));
    }
    public function addTrait(string $name) : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType
    {
        return $this->addNamespace(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::extractNamespace($name))->addTrait(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::extractShortName($name));
    }
    /** @param  string|PhpNamespace  $namespace */
    public function addNamespace($namespace) : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\PhpNamespace
    {
        if ($namespace instanceof \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\PhpNamespace) {
            $res = $this->namespaces[$namespace->getName()] = $namespace;
        } elseif (\is_string($namespace)) {
            $res = $this->namespaces[$namespace] = $this->namespaces[$namespace] ?? new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\PhpNamespace($namespace);
        } else {
            throw new \TenantCloud\BetterReflection\Relocated\Nette\InvalidArgumentException('Argument must be string|PhpNamespace.');
        }
        foreach ($this->namespaces as $namespace) {
            $namespace->setBracketedSyntax(\count($this->namespaces) > 1 && isset($this->namespaces['']));
        }
        return $res;
    }
    /** @return PhpNamespace[] */
    public function getNamespaces() : array
    {
        return $this->namespaces;
    }
    /** @return static */
    public function addUse(string $name, string $alias = null) : self
    {
        $this->addNamespace('')->addUse($name, $alias);
        return $this;
    }
    /**
     * Adds declare(strict_types=1) to output.
     * @return static
     */
    public function setStrictTypes(bool $on = \true) : self
    {
        $this->strictTypes = $on;
        return $this;
    }
    public function hasStrictTypes() : bool
    {
        return $this->strictTypes;
    }
    /** @deprecated  use hasStrictTypes() */
    public function getStrictTypes() : bool
    {
        return $this->strictTypes;
    }
    public function __toString() : string
    {
        try {
            return (new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Printer())->printFile($this);
        } catch (\Throwable $e) {
            if (\PHP_VERSION_ID >= 70400) {
                throw $e;
            }
            \trigger_error('Exception in ' . __METHOD__ . "(): {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}", \E_USER_ERROR);
            return '';
        }
    }
}
