<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Dependency;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeContext;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileFinder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser;
class DependencyDumper
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\DependencyResolver $dependencyResolver;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory $scopeFactory;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileFinder $fileFinder;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\DependencyResolver $dependencyResolver, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver, \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory $scopeFactory, \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileFinder $fileFinder)
    {
        $this->dependencyResolver = $dependencyResolver;
        $this->nodeScopeResolver = $nodeScopeResolver;
        $this->parser = $parser;
        $this->scopeFactory = $scopeFactory;
        $this->fileFinder = $fileFinder;
    }
    /**
     * @param string[] $files
     * @param callable(int $count): void $countCallback
     * @param callable(): void $progressCallback
     * @param string[]|null $analysedPaths
     * @return string[][]
     */
    public function dumpDependencies(array $files, callable $countCallback, callable $progressCallback, ?array $analysedPaths) : array
    {
        $analysedFiles = $files;
        if ($analysedPaths !== null) {
            $analysedFiles = $this->fileFinder->findFiles($analysedPaths)->getFiles();
        }
        $this->nodeScopeResolver->setAnalysedFiles($analysedFiles);
        $analysedFiles = \array_fill_keys($analysedFiles, \true);
        $dependencies = [];
        $countCallback(\count($files));
        foreach ($files as $file) {
            try {
                $parserNodes = $this->parser->parseFile($file);
            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\ParserErrorsException $e) {
                continue;
            }
            $fileDependencies = [];
            try {
                $this->nodeScopeResolver->processNodes($parserNodes, $this->scopeFactory->create(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeContext::create($file)), function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) use($analysedFiles, &$fileDependencies) : void {
                    $dependencies = $this->dependencyResolver->resolveDependencies($node, $scope);
                    $fileDependencies = \array_merge($fileDependencies, $dependencies->getFileDependencies($scope->getFile(), $analysedFiles));
                });
            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\AnalysedCodeException $e) {
                // pass
            }
            foreach (\array_unique($fileDependencies) as $fileDependency) {
                $dependencies[$fileDependency][] = $file;
            }
            $progressCallback();
        }
        return $dependencies;
    }
}
