<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter;

use TenantCloud\BetterReflection\Relocated\Nette\Utils\Json;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output;
class JsonErrorFormatter implements \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    private bool $pretty;
    public function __construct(bool $pretty)
    {
        $this->pretty = $pretty;
    }
    public function formatErrors(\TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult $analysisResult, \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $output) : int
    {
        $errorsArray = ['totals' => ['errors' => \count($analysisResult->getNotFileSpecificErrors()), 'file_errors' => \count($analysisResult->getFileSpecificErrors())], 'files' => [], 'errors' => []];
        foreach ($analysisResult->getFileSpecificErrors() as $fileSpecificError) {
            $file = $fileSpecificError->getFile();
            if (!\array_key_exists($file, $errorsArray['files'])) {
                $errorsArray['files'][$file] = ['errors' => 0, 'messages' => []];
            }
            $errorsArray['files'][$file]['errors']++;
            $errorsArray['files'][$file]['messages'][] = ['message' => $fileSpecificError->getMessage(), 'line' => $fileSpecificError->getLine(), 'ignorable' => $fileSpecificError->canBeIgnored()];
        }
        foreach ($analysisResult->getNotFileSpecificErrors() as $notFileSpecificError) {
            $errorsArray['errors'][] = $notFileSpecificError;
        }
        $json = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::encode($errorsArray, $this->pretty ? \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::PRETTY : 0);
        $output->writeRaw($json);
        return $analysisResult->hasErrors() ? 1 : 0;
    }
}
