<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Traits;

use TenantCloud\BetterReflection\Relocated\Nette;
/**
 * @internal
 */
trait NameAware
{
    /** @var string */
    private $name;
    public function __construct(string $name)
    {
        if (!\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::isIdentifier($name)) {
            throw new \TenantCloud\BetterReflection\Relocated\Nette\InvalidArgumentException("Value '{$name}' is not valid name.");
        }
        $this->name = $name;
    }
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * Returns clone with a different name.
     * @return static
     */
    public function cloneWithName(string $name) : self
    {
        $dolly = clone $this;
        $dolly->__construct($name);
        return $dolly;
    }
}
