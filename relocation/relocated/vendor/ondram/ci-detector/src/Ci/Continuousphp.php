<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Ci;

use TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\CiDetector;
use TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Env;
use TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\TrinaryLogic;
class Continuousphp extends \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('CONTINUOUSPHP') === 'continuousphp';
    }
    public function getCiName() : string
    {
        return \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\CiDetector::CI_CONTINUOUSPHP;
    }
    public function isPullRequest() : \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->getString('CPHP_PR_ID') !== '');
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('CPHP_BUILD_ID');
    }
    public function getBuildUrl() : string
    {
        return $this->env->getString('');
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('CPHP_GIT_COMMIT');
    }
    public function getGitBranch() : string
    {
        $gitReference = $this->env->getString('CPHP_GIT_REF');
        return \preg_replace('~^refs/heads/~', '', $gitReference) ?? '';
    }
    public function getRepositoryName() : string
    {
        return '';
        // unsupported
    }
    public function getRepositoryUrl() : string
    {
        return $this->env->getString('');
    }
}
