<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter;

use TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\RelativePathHelper;
/**
 * @see https://www.jetbrains.com/help/teamcity/build-script-interaction-with-teamcity.html#Reporting+Inspections
 */
class TeamcityErrorFormatter implements \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\RelativePathHelper $relativePathHelper;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->relativePathHelper = $relativePathHelper;
    }
    public function formatErrors(\TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult $analysisResult, \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $output) : int
    {
        $result = '';
        $fileSpecificErrors = $analysisResult->getFileSpecificErrors();
        $notFileSpecificErrors = $analysisResult->getNotFileSpecificErrors();
        $warnings = $analysisResult->getWarnings();
        if (\count($fileSpecificErrors) === 0 && \count($notFileSpecificErrors) === 0 && \count($warnings) === 0) {
            return 0;
        }
        $result .= $this->createTeamcityLine('inspectionType', ['id' => 'phpstan', 'name' => 'phpstan', 'category' => 'phpstan', 'description' => 'phpstan Inspection']);
        foreach ($fileSpecificErrors as $fileSpecificError) {
            $result .= $this->createTeamcityLine('inspection', [
                'typeId' => 'phpstan',
                'message' => $fileSpecificError->getMessage(),
                'file' => $this->relativePathHelper->getRelativePath($fileSpecificError->getFile()),
                'line' => $fileSpecificError->getLine(),
                // additional attributes
                'SEVERITY' => 'ERROR',
                'ignorable' => $fileSpecificError->canBeIgnored(),
                'tip' => $fileSpecificError->getTip(),
            ]);
        }
        foreach ($notFileSpecificErrors as $notFileSpecificError) {
            $result .= $this->createTeamcityLine('inspection', [
                'typeId' => 'phpstan',
                'message' => $notFileSpecificError,
                // the file is required
                'file' => $analysisResult->getProjectConfigFile() !== null ? $this->relativePathHelper->getRelativePath($analysisResult->getProjectConfigFile()) : '.',
                'SEVERITY' => 'ERROR',
            ]);
        }
        foreach ($warnings as $warning) {
            $result .= $this->createTeamcityLine('inspection', [
                'typeId' => 'phpstan',
                'message' => $warning,
                // the file is required
                'file' => $analysisResult->getProjectConfigFile() !== null ? $this->relativePathHelper->getRelativePath($analysisResult->getProjectConfigFile()) : '.',
                'SEVERITY' => 'WARNING',
            ]);
        }
        $output->writeRaw($result);
        return $analysisResult->hasErrors() ? 1 : 0;
    }
    /**
     * Creates a Teamcity report line
     *
     * @param string $messageName The message name
     * @param mixed[] $keyValuePairs The key=>value pairs
     * @return string The Teamcity report line
     */
    private function createTeamcityLine(string $messageName, array $keyValuePairs) : string
    {
        $string = '##teamcity[' . $messageName;
        foreach ($keyValuePairs as $key => $value) {
            if (\is_string($value)) {
                $value = $this->escape($value);
            }
            $string .= ' ' . $key . '=\'' . $value . '\'';
        }
        return $string . ']' . \PHP_EOL;
    }
    /**
     * Escapes the given string for Teamcity output
     *
     * @param string $string The string to escape
     * @return string The escaped string
     */
    private function escape(string $string) : string
    {
        $replacements = ['~\\n~' => '|n', '~\\r~' => '|r', '~([\'\\|\\[\\]])~' => '|$1'];
        return (string) \preg_replace(\array_keys($replacements), \array_values($replacements), $string);
    }
}
