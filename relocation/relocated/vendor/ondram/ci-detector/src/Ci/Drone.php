<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Ci;

use TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\CiDetector;
use TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Env;
use TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\TrinaryLogic;
class Drone extends \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('CI') === 'drone';
    }
    public function getCiName() : string
    {
        return \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\CiDetector::CI_DRONE;
    }
    public function isPullRequest() : \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->getString('DRONE_PULL_REQUEST') !== '');
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('DRONE_BUILD_NUMBER');
    }
    public function getBuildUrl() : string
    {
        return $this->env->getString('DRONE_BUILD_LINK');
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('DRONE_COMMIT_SHA');
    }
    public function getGitBranch() : string
    {
        return $this->env->getString('DRONE_COMMIT_BRANCH');
    }
    public function getRepositoryName() : string
    {
        return $this->env->getString('DRONE_REPO');
    }
    public function getRepositoryUrl() : string
    {
        return $this->env->getString('DRONE_REPO_LINK');
    }
}
