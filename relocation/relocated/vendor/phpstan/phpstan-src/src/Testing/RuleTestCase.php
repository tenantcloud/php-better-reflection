<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Testing;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Analyser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\FileAnalyser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\AnonymousClassNameHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache;
use TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\DependencyResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNodeResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocInheritanceResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocNodeResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocStringResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\DirectReflectionProviderProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Registry;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
/**
 * @template TRule of \PHPStan\Rules\Rule
 */
abstract class RuleTestCase extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Analyser $analyser = null;
    /**
     * @return \PHPStan\Rules\Rule
     * @phpstan-return TRule
     */
    protected abstract function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
    protected function getTypeSpecifier() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier
    {
        return $this->createTypeSpecifier(new \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard(), $this->createReflectionProvider(), $this->getMethodTypeSpecifyingExtensions(), $this->getStaticMethodTypeSpecifyingExtensions());
    }
    private function getAnalyser() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Analyser
    {
        if ($this->analyser === null) {
            $registry = new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Registry([$this->getRule()]);
            $broker = $this->createBroker();
            $printer = new \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard();
            $typeSpecifier = $this->createTypeSpecifier($printer, $broker, $this->getMethodTypeSpecifyingExtensions(), $this->getStaticMethodTypeSpecifyingExtensions());
            $currentWorkingDirectory = $this->getCurrentWorkingDirectory();
            $fileHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper($currentWorkingDirectory);
            $currentWorkingDirectory = $fileHelper->normalizePath($currentWorkingDirectory, '/');
            $fileHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper($currentWorkingDirectory);
            $relativePathHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper($currentWorkingDirectory);
            $anonymousClassNameHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\AnonymousClassNameHelper($fileHelper, $relativePathHelper);
            $fileTypeMapper = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper(new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\DirectReflectionProviderProvider($broker), $this->getParser(), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocStringResolver::class), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocNodeResolver::class), $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache::class), $anonymousClassNameHelper);
            $phpDocInheritanceResolver = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocInheritanceResolver($fileTypeMapper);
            $nodeScopeResolver = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver($broker, self::getReflectors()[0], $this->getClassReflectionExtensionRegistryProvider(), $this->getParser(), $fileTypeMapper, self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion::class), $phpDocInheritanceResolver, $fileHelper, $typeSpecifier, $this->shouldPolluteScopeWithLoopInitialAssignments(), $this->shouldPolluteCatchScopeWithTryAssignments(), $this->shouldPolluteScopeWithAlwaysIterableForeach(), [], []);
            $fileAnalyser = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\FileAnalyser($this->createScopeFactory($broker, $typeSpecifier), $nodeScopeResolver, $this->getParser(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\DependencyResolver($fileHelper, $broker, new \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNodeResolver($fileTypeMapper, $printer)), \true);
            $this->analyser = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Analyser($fileAnalyser, $registry, $nodeScopeResolver, 50);
        }
        return $this->analyser;
    }
    /**
     * @return \PHPStan\Type\MethodTypeSpecifyingExtension[]
     */
    protected function getMethodTypeSpecifyingExtensions() : array
    {
        return [];
    }
    /**
     * @return \PHPStan\Type\StaticMethodTypeSpecifyingExtension[]
     */
    protected function getStaticMethodTypeSpecifyingExtensions() : array
    {
        return [];
    }
    /**
     * @param string[] $files
     * @param mixed[] $expectedErrors
     */
    public function analyse(array $files, array $expectedErrors) : void
    {
        $files = \array_map([$this->getFileHelper(), 'normalizePath'], $files);
        $analyserResult = $this->getAnalyser()->analyse($files);
        if (\count($analyserResult->getInternalErrors()) > 0) {
            $this->fail(\implode("\n", $analyserResult->getInternalErrors()));
        }
        $actualErrors = $analyserResult->getUnorderedErrors();
        $strictlyTypedSprintf = static function (int $line, string $message, ?string $tip) : string {
            $message = \sprintf('%02d: %s', $line, $message);
            if ($tip !== null) {
                $message .= "\n    💡 " . $tip;
            }
            return $message;
        };
        $expectedErrors = \array_map(static function (array $error) use($strictlyTypedSprintf) : string {
            if (!isset($error[0])) {
                throw new \InvalidArgumentException('Missing expected error message.');
            }
            if (!isset($error[1])) {
                throw new \InvalidArgumentException('Missing expected file line.');
            }
            return $strictlyTypedSprintf($error[1], $error[0], $error[2] ?? null);
        }, $expectedErrors);
        $actualErrors = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error $error) use($strictlyTypedSprintf) : string {
            $line = $error->getLine();
            if ($line === null) {
                return $strictlyTypedSprintf(-1, $error->getMessage(), $error->getTip());
            }
            return $strictlyTypedSprintf($line, $error->getMessage(), $error->getTip());
        }, $actualErrors);
        $this->assertSame(\implode("\n", $expectedErrors) . "\n", \implode("\n", $actualErrors) . "\n");
    }
    protected function shouldPolluteScopeWithLoopInitialAssignments() : bool
    {
        return \false;
    }
    protected function shouldPolluteCatchScopeWithTryAssignments() : bool
    {
        return \false;
    }
    protected function shouldPolluteScopeWithAlwaysIterableForeach() : bool
    {
        return \true;
    }
}
