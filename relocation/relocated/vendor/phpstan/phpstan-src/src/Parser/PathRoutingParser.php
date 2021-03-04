<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Parser;

use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
class PathRoutingParser implements \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $currentPhpVersionRichParser;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $currentPhpVersionSimpleParser;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $php8Parser;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $currentPhpVersionRichParser, \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $currentPhpVersionSimpleParser, \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $php8Parser)
    {
        $this->fileHelper = $fileHelper;
        $this->currentPhpVersionRichParser = $currentPhpVersionRichParser;
        $this->currentPhpVersionSimpleParser = $currentPhpVersionSimpleParser;
        $this->php8Parser = $php8Parser;
    }
    public function parseFile(string $file) : array
    {
        $file = $this->fileHelper->normalizePath($file, '/');
        if (\strpos($file, 'vendor/jetbrains/phpstorm-stubs') !== \false) {
            return $this->php8Parser->parseFile($file);
        }
        return $this->currentPhpVersionRichParser->parseFile($file);
    }
    public function parseString(string $sourceCode) : array
    {
        return $this->currentPhpVersionSimpleParser->parseString($sourceCode);
    }
}
