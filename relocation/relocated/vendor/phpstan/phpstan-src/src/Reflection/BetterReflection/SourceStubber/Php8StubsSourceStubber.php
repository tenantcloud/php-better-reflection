<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceStubber;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\SourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\StubData;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php8StubsMap;
class Php8StubsSourceStubber implements \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\SourceStubber
{
    private const DIRECTORY = __DIR__ . '/../../../../vendor/phpstan/php-8-stubs';
    public function hasClass(string $className) : bool
    {
        $className = \strtolower($className);
        return \array_key_exists($className, \TenantCloud\BetterReflection\Relocated\PHPStan\Php8StubsMap::CLASSES);
    }
    public function generateClassStub(string $className) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        $lowerClassName = \strtolower($className);
        if (!\array_key_exists($lowerClassName, \TenantCloud\BetterReflection\Relocated\PHPStan\Php8StubsMap::CLASSES)) {
            return null;
        }
        $relativeFilePath = \TenantCloud\BetterReflection\Relocated\PHPStan\Php8StubsMap::CLASSES[$lowerClassName];
        $file = self::DIRECTORY . '/' . $relativeFilePath;
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\StubData(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader::read($file), $this->getExtensionFromFilePath($relativeFilePath), $file);
    }
    public function generateFunctionStub(string $functionName) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        $lowerFunctionName = \strtolower($functionName);
        if (!\array_key_exists($lowerFunctionName, \TenantCloud\BetterReflection\Relocated\PHPStan\Php8StubsMap::FUNCTIONS)) {
            return null;
        }
        $relativeFilePath = \TenantCloud\BetterReflection\Relocated\PHPStan\Php8StubsMap::FUNCTIONS[$lowerFunctionName];
        $file = self::DIRECTORY . '/' . $relativeFilePath;
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\StubData(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader::read($file), $this->getExtensionFromFilePath($relativeFilePath), $file);
    }
    public function generateConstantStub(string $constantName) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        return null;
    }
    private function getExtensionFromFilePath(string $relativeFilePath) : string
    {
        $pathParts = \explode('/', $relativeFilePath);
        if ($pathParts[1] === 'Zend') {
            return 'Core';
        }
        return $pathParts[2];
    }
}
