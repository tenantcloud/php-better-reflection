<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Dependency;

use IteratorAggregate;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionWithFilename;
/**
 * @implements \IteratorAggregate<int, ReflectionWithFilename>
 */
class NodeDependencies implements \IteratorAggregate
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper;
    /** @var ReflectionWithFilename[] */
    private array $reflections;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNode $exportedNode;
    /**
     * @param FileHelper $fileHelper
     * @param ReflectionWithFilename[] $reflections
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper, array $reflections, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNode $exportedNode)
    {
        $this->fileHelper = $fileHelper;
        $this->reflections = $reflections;
        $this->exportedNode = $exportedNode;
    }
    public function getIterator() : \Traversable
    {
        return new \ArrayIterator($this->reflections);
    }
    /**
     * @param string $currentFile
     * @param array<string, true> $analysedFiles
     * @return string[]
     */
    public function getFileDependencies(string $currentFile, array $analysedFiles) : array
    {
        $dependencies = [];
        foreach ($this->reflections as $dependencyReflection) {
            $dependencyFile = $dependencyReflection->getFileName();
            if ($dependencyFile === \false) {
                continue;
            }
            $dependencyFile = $this->fileHelper->normalizePath($dependencyFile);
            if ($currentFile === $dependencyFile) {
                continue;
            }
            if (!isset($analysedFiles[$dependencyFile])) {
                continue;
            }
            $dependencies[$dependencyFile] = $dependencyFile;
        }
        return \array_values($dependencies);
    }
    public function getExportedNode() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNode
    {
        return $this->exportedNode;
    }
}
