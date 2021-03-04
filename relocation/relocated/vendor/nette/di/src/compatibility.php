<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\DI\Config;

if (\false) {
    /** @deprecated use Nette\DI\Config\Adapter */
    interface IAdapter
    {
    }
} elseif (!\interface_exists(\TenantCloud\BetterReflection\Relocated\Nette\DI\Config\IAdapter::class)) {
    \class_alias(\TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Adapter::class, \TenantCloud\BetterReflection\Relocated\Nette\DI\Config\IAdapter::class);
}
namespace TenantCloud\BetterReflection\Relocated\Nette\DI;

if (\false) {
    /** @deprecated use Nette\DI\Definitions\ServiceDefinition */
    class ServiceDefinition
    {
    }
} elseif (!\class_exists(\TenantCloud\BetterReflection\Relocated\Nette\DI\ServiceDefinition::class)) {
    \class_alias(\TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\ServiceDefinition::class, \TenantCloud\BetterReflection\Relocated\Nette\DI\ServiceDefinition::class);
}
if (\false) {
    /** @deprecated use Nette\DI\Definitions\Statement */
    class Statement
    {
    }
} elseif (!\class_exists(\TenantCloud\BetterReflection\Relocated\Nette\DI\Statement::class)) {
    \class_alias(\TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement::class, \TenantCloud\BetterReflection\Relocated\Nette\DI\Statement::class);
}
