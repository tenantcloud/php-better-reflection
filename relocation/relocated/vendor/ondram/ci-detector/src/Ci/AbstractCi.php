<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Ci;

use TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Env;
/**
 * Unified adapter to retrieve environment variables from current continuous integration server
 */
abstract class AbstractCi implements \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Ci\CiInterface
{
    /** @var Env */
    protected $env;
    public function __construct(\TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Env $env)
    {
        $this->env = $env;
    }
}
