<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter;

use TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output;
class RawErrorFormatter implements \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    public function formatErrors(\TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult $analysisResult, \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $output) : int
    {
        foreach ($analysisResult->getNotFileSpecificErrors() as $notFileSpecificError) {
            $output->writeRaw(\sprintf('?:?:%s', $notFileSpecificError));
            $output->writeLineFormatted('');
        }
        foreach ($analysisResult->getFileSpecificErrors() as $fileSpecificError) {
            $output->writeRaw(\sprintf('%s:%d:%s', $fileSpecificError->getFile(), $fileSpecificError->getLine() ?? '?', $fileSpecificError->getMessage()));
            $output->writeLineFormatted('');
        }
        foreach ($analysisResult->getWarnings() as $warning) {
            $output->writeRaw(\sprintf('?:?:%s', $warning));
            $output->writeLineFormatted('');
        }
        return $analysisResult->hasErrors() ? 1 : 0;
    }
}
