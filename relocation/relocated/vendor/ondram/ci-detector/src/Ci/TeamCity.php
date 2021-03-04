<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Ci;

use TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\CiDetector;
use TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Env;
use TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\TrinaryLogic;
class TeamCity extends \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('TEAMCITY_VERSION') !== \false;
    }
    public function getCiName() : string
    {
        return \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\CiDetector::CI_TEAMCITY;
    }
    public function isPullRequest() : \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\TrinaryLogic::createMaybe();
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('BUILD_NUMBER');
    }
    public function getBuildUrl() : string
    {
        return '';
        // unsupported
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('BUILD_VCS_NUMBER');
    }
    public function getGitBranch() : string
    {
        return '';
        // unsupported
    }
    public function getRepositoryName() : string
    {
        return '';
        // unsupported
    }
    public function getRepositoryUrl() : string
    {
        return '';
        // unsupported
    }
}
