<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
interface BrokerAwareExtension
{
    public function setBroker(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker $broker) : void;
}
