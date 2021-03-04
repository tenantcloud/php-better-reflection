<?php

namespace TenantCloud\BetterReflection\Relocated\Psr\Log;

/**
 * Describes a logger-aware instance.
 */
interface LoggerAwareInterface
{
    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(\TenantCloud\BetterReflection\Relocated\Psr\Log\LoggerInterface $logger);
}
