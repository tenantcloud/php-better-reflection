<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Dependency;

use TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileFinder;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
use TenantCloud\BetterReflection\Relocated\Tests\Dependency\Child;
use TenantCloud\BetterReflection\Relocated\Tests\Dependency\GrandChild;
use TenantCloud\BetterReflection\Relocated\Tests\Dependency\ParentClass;
class DependencyDumperTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testDumpDependencies() : void
    {
        $container = self::getContainer();
        /** @var NodeScopeResolver $nodeScopeResolver */
        $nodeScopeResolver = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver::class);
        /** @var Parser $realParser */
        $realParser = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser::class);
        $mockParser = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser::class);
        $mockParser->method('parseFile')->willReturnCallback(static function (string $file) use($realParser) : array {
            if (\file_exists($file)) {
                return $realParser->parseFile($file);
            }
            return [];
        });
        /** @var Broker $realBroker */
        $realBroker = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        $fileHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper(__DIR__);
        $mockBroker = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        $mockBroker->method('getClass')->willReturnCallback(function (string $class) use($realBroker, $fileHelper) : ClassReflection {
            if (\in_array($class, [\TenantCloud\BetterReflection\Relocated\Tests\Dependency\GrandChild::class, \TenantCloud\BetterReflection\Relocated\Tests\Dependency\Child::class, \TenantCloud\BetterReflection\Relocated\Tests\Dependency\ParentClass::class], \true)) {
                return $realBroker->getClass($class);
            }
            $nameParts = \explode('\\', $class);
            $shortClass = \array_pop($nameParts);
            $classReflection = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection::class);
            $classReflection->method('getInterfaces')->willReturn([]);
            $classReflection->method('getTraits')->willReturn([]);
            $classReflection->method('getParentClass')->willReturn(\false);
            $classReflection->method('getFilename')->willReturn($fileHelper->normalizePath(__DIR__ . '/data/' . $shortClass . '.php'));
            return $classReflection;
        });
        $expectedDependencyTree = $this->getExpectedDependencyTree($fileHelper);
        /** @var ScopeFactory $scopeFactory */
        $scopeFactory = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory::class);
        /** @var FileFinder $fileFinder */
        $fileFinder = $container->getService('fileFinderAnalyse');
        $dumper = new \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\DependencyDumper(new \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\DependencyResolver($fileHelper, $mockBroker, new \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNodeResolver(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class), new \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard())), $nodeScopeResolver, $mockParser, $scopeFactory, $fileFinder);
        $dependencies = $dumper->dumpDependencies(\array_merge([$fileHelper->normalizePath(__DIR__ . '/data/GrandChild.php')], \array_keys($expectedDependencyTree)), static function () : void {
        }, static function () : void {
        }, null);
        $this->assertCount(\count($expectedDependencyTree), $dependencies);
        foreach ($expectedDependencyTree as $file => $files) {
            $this->assertArrayHasKey($file, $dependencies);
            $this->assertSame($files, $dependencies[$file]);
        }
    }
    /**
     * @param FileHelper $fileHelper
     * @return string[][]
     */
    private function getExpectedDependencyTree(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper) : array
    {
        $tree = ['Child.php' => ['GrandChild.php'], 'Parent.php' => ['GrandChild.php', 'Child.php'], 'MethodNativeReturnTypehint.php' => ['GrandChild.php'], 'MethodPhpDocReturnTypehint.php' => ['GrandChild.php'], 'ParamNativeReturnTypehint.php' => ['GrandChild.php'], 'ParamPhpDocReturnTypehint.php' => ['GrandChild.php']];
        $expectedTree = [];
        foreach ($tree as $file => $files) {
            $expectedTree[$fileHelper->normalizePath(__DIR__ . '/data/' . $file)] = \array_map(static function (string $file) use($fileHelper) : string {
                return $fileHelper->normalizePath(__DIR__ . '/data/' . $file);
            }, $files);
        }
        return $expectedTree;
    }
}
