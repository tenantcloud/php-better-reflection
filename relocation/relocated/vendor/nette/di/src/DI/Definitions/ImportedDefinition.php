<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions;

use TenantCloud\BetterReflection\Relocated\Nette;
use TenantCloud\BetterReflection\Relocated\Nette\DI\PhpGenerator;
/**
 * Imported service injected to the container.
 */
final class ImportedDefinition extends \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Definition
{
    /** @return static */
    public function setType(?string $type)
    {
        return parent::setType($type);
    }
    public function resolveType(\TenantCloud\BetterReflection\Relocated\Nette\DI\Resolver $resolver) : void
    {
    }
    public function complete(\TenantCloud\BetterReflection\Relocated\Nette\DI\Resolver $resolver) : void
    {
    }
    public function generateMethod(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Method $method, \TenantCloud\BetterReflection\Relocated\Nette\DI\PhpGenerator $generator) : void
    {
        $method->setReturnType('void')->setBody('throw new Nette\\DI\\ServiceCreationException(?);', ["Unable to create imported service '{$this->getName()}', it must be added using addService()"]);
    }
    /** @deprecated use '$def instanceof ImportedDefinition' */
    public function isDynamic() : bool
    {
        return \true;
    }
}
