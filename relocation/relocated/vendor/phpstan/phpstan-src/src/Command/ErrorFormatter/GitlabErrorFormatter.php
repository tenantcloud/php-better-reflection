<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter;

use TenantCloud\BetterReflection\Relocated\Nette\Utils\Json;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\RelativePathHelper;
/**
 * @see https://docs.gitlab.com/ee/user/project/merge_requests/code_quality.html#implementing-a-custom-tool
 */
class GitlabErrorFormatter implements \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\RelativePathHelper $relativePathHelper;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->relativePathHelper = $relativePathHelper;
    }
    public function formatErrors(\TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult $analysisResult, \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $output) : int
    {
        $errorsArray = [];
        foreach ($analysisResult->getFileSpecificErrors() as $fileSpecificError) {
            $error = ['description' => $fileSpecificError->getMessage(), 'fingerprint' => \hash('sha256', \implode([$fileSpecificError->getFile(), $fileSpecificError->getLine(), $fileSpecificError->getMessage()])), 'location' => ['path' => $this->relativePathHelper->getRelativePath($fileSpecificError->getFile()), 'lines' => ['begin' => $fileSpecificError->getLine()]]];
            if (!$fileSpecificError->canBeIgnored()) {
                $error['severity'] = 'blocker';
            }
            $errorsArray[] = $error;
        }
        foreach ($analysisResult->getNotFileSpecificErrors() as $notFileSpecificError) {
            $errorsArray[] = ['description' => $notFileSpecificError, 'fingerprint' => \hash('sha256', $notFileSpecificError), 'location' => ['path' => '', 'lines' => ['begin' => 0]]];
        }
        $json = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::encode($errorsArray, \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::PRETTY);
        $output->writeRaw($json);
        return $analysisResult->hasErrors() ? 1 : 0;
    }
}
