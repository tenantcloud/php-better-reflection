<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileExcluder;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
class IgnoredError
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param mixed[]|string $ignoredError
     * @return string Representation of the ignored error
     */
    public static function stringifyPattern($ignoredError) : string
    {
        if (!\is_array($ignoredError)) {
            return $ignoredError;
        }
        // ignore by path
        if (isset($ignoredError['path'])) {
            return \sprintf('%s in path %s', $ignoredError['message'], $ignoredError['path']);
        } elseif (isset($ignoredError['paths'])) {
            if (\count($ignoredError['paths']) === 1) {
                return \sprintf('%s in path %s', $ignoredError['message'], \implode(', ', $ignoredError['paths']));
            }
            return \sprintf('%s in paths: %s', $ignoredError['message'], \implode(', ', $ignoredError['paths']));
        }
        return $ignoredError['message'];
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param FileHelper $fileHelper
     * @param Error $error
     * @param string $ignoredErrorPattern
     * @param string|null $path
     * @return bool To ignore or not to ignore?
     */
    public static function shouldIgnore(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error $error, string $ignoredErrorPattern, ?string $path) : bool
    {
        // normalize newlines to allow working with ignore-patterns independent of used OS newline-format
        $errorMessage = $error->getMessage();
        $errorMessage = \str_replace(['\\r\\n', '\\r'], '\\n', $errorMessage);
        $ignoredErrorPattern = \str_replace([\preg_quote('TenantCloud\\BetterReflection\\Relocated\\r\\n'), \preg_quote('\\r')], \preg_quote('\\n'), $ignoredErrorPattern);
        if ($path !== null) {
            $fileExcluder = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileExcluder($fileHelper, [$path], []);
            if (\TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::match($errorMessage, $ignoredErrorPattern) === null) {
                return \false;
            }
            $isExcluded = $fileExcluder->isExcludedFromAnalysing($error->getFilePath());
            if (!$isExcluded && $error->getTraitFilePath() !== null) {
                return $fileExcluder->isExcludedFromAnalysing($error->getTraitFilePath());
            }
            return $isExcluded;
        }
        return \TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::match($errorMessage, $ignoredErrorPattern) !== null;
    }
}
