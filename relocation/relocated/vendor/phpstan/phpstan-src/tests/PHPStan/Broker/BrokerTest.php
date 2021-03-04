<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Broker;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocNodeResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocStringResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflectionFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Runtime\RuntimeReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
class BrokerTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    /** @var \PHPStan\Broker\Broker */
    private $broker;
    protected function setUp() : void
    {
        $phpDocStringResolver = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocStringResolver::class);
        $phpDocNodeResolver = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocNodeResolver::class);
        $workingDirectory = __DIR__;
        $relativePathHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper($workingDirectory);
        $fileHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper($workingDirectory);
        $anonymousClassNameHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\AnonymousClassNameHelper($fileHelper, $relativePathHelper);
        $classReflectionExtensionRegistryProvider = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider([], []);
        $dynamicReturnTypeExtensionRegistryProvider = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider([], [], []);
        $operatorTypeSpecifyingExtensionRegistryProvider = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider([]);
        $setterReflectionProviderProvider = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $reflectionProvider = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Runtime\RuntimeReflectionProvider($setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflectionFactory::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper($setterReflectionProviderProvider, $this->getParser(), $phpDocStringResolver, $phpDocNodeResolver, $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache::class), $anonymousClassNameHelper), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion::class), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider::class), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider::class), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber::class));
        $setterReflectionProviderProvider->setReflectionProvider($reflectionProvider);
        $this->broker = new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker($reflectionProvider, $dynamicReturnTypeExtensionRegistryProvider, $operatorTypeSpecifyingExtensionRegistryProvider, []);
        $classReflectionExtensionRegistryProvider->setBroker($this->broker);
        $dynamicReturnTypeExtensionRegistryProvider->setBroker($this->broker);
        $operatorTypeSpecifyingExtensionRegistryProvider->setBroker($this->broker);
    }
    public function testClassNotFound() : void
    {
        $this->expectException(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassNotFoundException::class);
        $this->expectExceptionMessage('NonexistentClass');
        $this->broker->getClass('NonexistentClass');
    }
    public function testFunctionNotFound() : void
    {
        $this->expectException(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\FunctionNotFoundException::class);
        $this->expectExceptionMessage('Function nonexistentFunction not found while trying to analyse it - discovering symbols is probably not configured properly.');
        $scope = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope::class);
        $scope->method('getNamespace')->willReturn(null);
        $this->broker->getFunction(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name('nonexistentFunction'), $scope);
    }
    public function testClassAutoloadingException() : void
    {
        $this->expectException(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassAutoloadingException::class);
        $this->expectExceptionMessage('thrown while looking for class NonexistentClass.');
        \spl_autoload_register(static function () : void {
            require_once __DIR__ . '/../Analyser/data/parse-error.php';
        }, \true, \true);
        $this->broker->hasClass('NonexistentClass');
    }
}
