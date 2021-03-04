<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Php;

use TenantCloud\BetterReflection\Relocated\Nette\Utils\Json;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader;
class PhpVersionFactoryFactory
{
    private ?int $versionId;
    private bool $readComposerPhpVersion;
    /** @var string[] */
    private array $composerAutoloaderProjectPaths;
    /**
     * @param bool $readComposerPhpVersion
     * @param string[] $composerAutoloaderProjectPaths
     */
    public function __construct(?int $versionId, bool $readComposerPhpVersion, array $composerAutoloaderProjectPaths)
    {
        $this->versionId = $versionId;
        $this->readComposerPhpVersion = $readComposerPhpVersion;
        $this->composerAutoloaderProjectPaths = $composerAutoloaderProjectPaths;
    }
    public function create() : \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersionFactory
    {
        $composerPhpVersion = null;
        if ($this->readComposerPhpVersion && \count($this->composerAutoloaderProjectPaths) > 0) {
            $composerJsonPath = \end($this->composerAutoloaderProjectPaths) . '/composer.json';
            if (\is_file($composerJsonPath)) {
                try {
                    $composerJsonContents = \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader::read($composerJsonPath);
                    $composer = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::decode($composerJsonContents, \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::FORCE_ARRAY);
                    $platformVersion = $composer['config']['platform']['php'] ?? null;
                    if (\is_string($platformVersion)) {
                        $composerPhpVersion = $platformVersion;
                    }
                } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\File\CouldNotReadFileException|\TenantCloud\BetterReflection\Relocated\Nette\Utils\JsonException $e) {
                    // pass
                }
            }
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersionFactory($this->versionId, $composerPhpVersion);
    }
}
