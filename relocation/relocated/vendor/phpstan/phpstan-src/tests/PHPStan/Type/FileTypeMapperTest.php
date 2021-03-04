<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

class FileTypeMapperTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testGetResolvedPhpDoc() : void
    {
        /** @var FileTypeMapper $fileTypeMapper */
        $fileTypeMapper = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class);
        $resolvedA = $fileTypeMapper->getResolvedPhpDoc(__DIR__ . '/data/annotations.php', 'Foo', null, null, '/**
 * @property int | float $numericBazBazProperty
 * @property X $singleLetterObjectName
 *
 * @method void simpleMethod()
 * @method string returningMethod()
 * @method ?float returningNullableScalar()
 * @method ?\\stdClass returningNullableObject()
 * @method void complicatedParameters(string $a, ?int|?float|?\\stdClass $b, \\stdClass $c = null, string|?int $d)
 * @method Image rotate(float $angle, $backgroundColor)
 * @method int | float paramMultipleTypesWithExtraSpaces(string | null $string, stdClass | null $object)
 */');
        $this->assertCount(0, $resolvedA->getVarTags());
        $this->assertCount(0, $resolvedA->getParamTags());
        $this->assertCount(2, $resolvedA->getPropertyTags());
        $this->assertNull($resolvedA->getReturnTag());
        $this->assertSame('float|int', $resolvedA->getPropertyTags()['numericBazBazProperty']->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertSame('X', $resolvedA->getPropertyTags()['singleLetterObjectName']->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertCount(6, $resolvedA->getMethodTags());
        $this->assertArrayNotHasKey('complicatedParameters', $resolvedA->getMethodTags());
        // ambiguous parameter types
        $simpleMethod = $resolvedA->getMethodTags()['simpleMethod'];
        $this->assertSame('void', $simpleMethod->getReturnType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertFalse($simpleMethod->isStatic());
        $this->assertCount(0, $simpleMethod->getParameters());
        $returningMethod = $resolvedA->getMethodTags()['returningMethod'];
        $this->assertSame('string', $returningMethod->getReturnType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertFalse($returningMethod->isStatic());
        $this->assertCount(0, $returningMethod->getParameters());
        $returningNullableScalar = $resolvedA->getMethodTags()['returningNullableScalar'];
        $this->assertSame('float|null', $returningNullableScalar->getReturnType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertFalse($returningNullableScalar->isStatic());
        $this->assertCount(0, $returningNullableScalar->getParameters());
        $returningNullableObject = $resolvedA->getMethodTags()['returningNullableObject'];
        $this->assertSame('stdClass|null', $returningNullableObject->getReturnType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertFalse($returningNullableObject->isStatic());
        $this->assertCount(0, $returningNullableObject->getParameters());
        $rotate = $resolvedA->getMethodTags()['rotate'];
        $this->assertSame('Image', $rotate->getReturnType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertFalse($rotate->isStatic());
        $this->assertCount(2, $rotate->getParameters());
        $this->assertSame('float', $rotate->getParameters()['angle']->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertTrue($rotate->getParameters()['angle']->passedByReference()->no());
        $this->assertFalse($rotate->getParameters()['angle']->isOptional());
        $this->assertFalse($rotate->getParameters()['angle']->isVariadic());
        $this->assertSame('mixed', $rotate->getParameters()['backgroundColor']->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertTrue($rotate->getParameters()['backgroundColor']->passedByReference()->no());
        $this->assertFalse($rotate->getParameters()['backgroundColor']->isOptional());
        $this->assertFalse($rotate->getParameters()['backgroundColor']->isVariadic());
        $paramMultipleTypesWithExtraSpaces = $resolvedA->getMethodTags()['paramMultipleTypesWithExtraSpaces'];
        $this->assertSame('float|int', $paramMultipleTypesWithExtraSpaces->getReturnType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertFalse($paramMultipleTypesWithExtraSpaces->isStatic());
        $this->assertCount(2, $paramMultipleTypesWithExtraSpaces->getParameters());
        $this->assertSame('string|null', $paramMultipleTypesWithExtraSpaces->getParameters()['string']->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertTrue($paramMultipleTypesWithExtraSpaces->getParameters()['string']->passedByReference()->no());
        $this->assertFalse($paramMultipleTypesWithExtraSpaces->getParameters()['string']->isOptional());
        $this->assertFalse($paramMultipleTypesWithExtraSpaces->getParameters()['string']->isVariadic());
        $this->assertSame('stdClass|null', $paramMultipleTypesWithExtraSpaces->getParameters()['object']->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertTrue($paramMultipleTypesWithExtraSpaces->getParameters()['object']->passedByReference()->no());
        $this->assertFalse($paramMultipleTypesWithExtraSpaces->getParameters()['object']->isOptional());
        $this->assertFalse($paramMultipleTypesWithExtraSpaces->getParameters()['object']->isVariadic());
    }
    public function testFileWithDependentPhpDocs() : void
    {
        /** @var FileTypeMapper $fileTypeMapper */
        $fileTypeMapper = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class);
        $realpath = \realpath(__DIR__ . '/data/dependent-phpdocs.php');
        if ($realpath === \false) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $resolved = $fileTypeMapper->getResolvedPhpDoc($realpath, \TenantCloud\BetterReflection\Relocated\DependentPhpDocs\Foo::class, null, 'addPages', '/** @param Foo[]|Foo|\\Iterator $pages */');
        $this->assertCount(1, $resolved->getParamTags());
        $this->assertSame('(DependentPhpDocs\\Foo&iterable<DependentPhpDocs\\Foo>)|(iterable<DependentPhpDocs\\Foo>&Iterator)', $resolved->getParamTags()['pages']->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
    }
    public function testFileThrowsPhpDocs() : void
    {
        /** @var FileTypeMapper $fileTypeMapper */
        $fileTypeMapper = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class);
        $realpath = \realpath(__DIR__ . '/data/throws-phpdocs.php');
        if ($realpath === \false) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $resolved = $fileTypeMapper->getResolvedPhpDoc($realpath, \TenantCloud\BetterReflection\Relocated\ThrowsPhpDocs\Foo::class, null, 'throwRuntimeException', '/**
 * @throws RuntimeException
 */');
        $this->assertNotNull($resolved->getThrowsTag());
        $this->assertSame(\RuntimeException::class, $resolved->getThrowsTag()->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $resolved = $fileTypeMapper->getResolvedPhpDoc($realpath, \TenantCloud\BetterReflection\Relocated\ThrowsPhpDocs\Foo::class, null, 'throwRuntimeAndLogicException', '/**
 * @throws RuntimeException|LogicException
 */');
        $this->assertNotNull($resolved->getThrowsTag());
        $this->assertSame('LogicException|RuntimeException', $resolved->getThrowsTag()->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $resolved = $fileTypeMapper->getResolvedPhpDoc($realpath, \TenantCloud\BetterReflection\Relocated\ThrowsPhpDocs\Foo::class, null, 'throwRuntimeAndLogicException2', '/**
 * @throws RuntimeException
 * @throws LogicException
 */');
        $this->assertNotNull($resolved->getThrowsTag());
        $this->assertSame('LogicException|RuntimeException', $resolved->getThrowsTag()->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
    }
    public function testFileWithCyclicPhpDocs() : void
    {
        self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        /** @var FileTypeMapper $fileTypeMapper */
        $fileTypeMapper = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class);
        $realpath = \realpath(__DIR__ . '/data/cyclic-phpdocs.php');
        if ($realpath === \false) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $resolved = $fileTypeMapper->getResolvedPhpDoc($realpath, \TenantCloud\BetterReflection\Relocated\CyclicPhpDocs\Foo::class, null, 'getIterator', '/** @return iterable<Foo> | Foo */');
        /** @var \PHPStan\PhpDoc\Tag\ReturnTag $returnTag */
        $returnTag = $resolved->getReturnTag();
        $this->assertSame('CyclicPhpDocs\\Foo|iterable<CyclicPhpDocs\\Foo>', $returnTag->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
    }
}
