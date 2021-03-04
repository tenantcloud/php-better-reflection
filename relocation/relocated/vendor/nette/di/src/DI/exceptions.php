<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\DI;

use TenantCloud\BetterReflection\Relocated\Nette;
/**
 * Service not found exception.
 */
class MissingServiceException extends \TenantCloud\BetterReflection\Relocated\Nette\InvalidStateException
{
}
/**
 * Service creation exception.
 */
class ServiceCreationException extends \TenantCloud\BetterReflection\Relocated\Nette\InvalidStateException
{
    public function setMessage(string $message) : self
    {
        $this->message = $message;
        return $this;
    }
}
/**
 * Not allowed when container is resolving.
 */
class NotAllowedDuringResolvingException extends \TenantCloud\BetterReflection\Relocated\Nette\InvalidStateException
{
}
/**
 * Error in configuration.
 */
class InvalidConfigurationException extends \TenantCloud\BetterReflection\Relocated\Nette\InvalidStateException
{
}
