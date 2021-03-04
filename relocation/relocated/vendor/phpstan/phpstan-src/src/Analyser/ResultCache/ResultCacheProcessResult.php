<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ResultCache;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\AnalyserResult;
class ResultCacheProcessResult
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\AnalyserResult $analyserResult;
    private bool $saved;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\AnalyserResult $analyserResult, bool $saved)
    {
        $this->analyserResult = $analyserResult;
        $this->saved = $saved;
    }
    public function getAnalyserResult() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\AnalyserResult
    {
        return $this->analyserResult;
    }
    public function isSaved() : bool
    {
        return $this->saved;
    }
}
