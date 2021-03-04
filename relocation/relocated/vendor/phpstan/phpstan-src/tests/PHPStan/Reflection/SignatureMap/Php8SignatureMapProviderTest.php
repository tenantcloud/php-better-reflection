<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap;

use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php8StubsMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType;
class Php8SignatureMapProviderTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataFunctions() : array
    {
        return [['curl_init', [['name' => 'url', 'optional' => \true, 'type' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), 'nativeType' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), 'passedByReference' => \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), 'variadic' => \false]], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('CurlHandle'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false)]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('CurlHandle'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false)]), \false], ['curl_exec', [['name' => 'handle', 'optional' => \false, 'type' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('CurlHandle'), 'nativeType' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('CurlHandle'), 'passedByReference' => \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), 'variadic' => \false]], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType()]), \false], ['date_get_last_errors', [], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('warning_count'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('warnings'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('error_count'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('errors')], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType())])]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true))]), \false], ['end', [['name' => 'array', 'optional' => \false, 'type' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), 'nativeType' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), 'passedByReference' => \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createReadsArgument(), 'variadic' => \false]], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), \false]];
    }
    /**
     * @dataProvider dataFunctions
     * @param mixed[] $parameters
     */
    public function testFunctions(string $functionName, array $parameters, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $returnType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $nativeReturnType, bool $variadic) : void
    {
        $provider = $this->createProvider();
        $signature = $provider->getFunctionSignature($functionName, null);
        $this->assertSignature($parameters, $returnType, $nativeReturnType, $variadic, $signature);
    }
    private function createProvider() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\Php8SignatureMapProvider
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\Php8SignatureMapProvider(new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\FunctionSignatureMapProvider(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\SignatureMapParser::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion(80000)), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher::class), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class));
    }
    public function dataMethods() : array
    {
        return [['Closure', 'bindTo', [['name' => 'newThis', 'optional' => \false, 'type' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), 'nativeType' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), 'passedByReference' => \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), 'variadic' => \false], ['name' => 'newScope', 'optional' => \true, 'type' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), 'nativeType' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), 'passedByReference' => \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), 'variadic' => \false]], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Closure'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Closure'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), \false], ['ArrayIterator', 'uasort', [['name' => 'callback', 'optional' => \false, 'type' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \false), 'nativeType' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), 'passedByReference' => \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), 'variadic' => \false]], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \false], [
            'RecursiveArrayIterator',
            'uasort',
            [[
                'name' => 'cmp_function',
                'optional' => \false,
                'type' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \false),
                'nativeType' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(),
                // todo - because uasort is not found in file with RecursiveArrayIterator
                'passedByReference' => \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(),
                'variadic' => \false,
            ]],
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType(),
            new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(),
            // todo - because uasort is not found in file with RecursiveArrayIterator
            \false,
        ]];
    }
    /**
     * @dataProvider dataMethods
     * @param mixed[] $parameters
     */
    public function testMethods(string $className, string $methodName, array $parameters, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $returnType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $nativeReturnType, bool $variadic) : void
    {
        $provider = $this->createProvider();
        $signature = $provider->getMethodSignature($className, $methodName, null);
        $this->assertSignature($parameters, $returnType, $nativeReturnType, $variadic, $signature);
    }
    /**
     * @param mixed[] $expectedParameters
     * @param Type $expectedReturnType
     * @param Type $expectedNativeReturnType
     * @param bool $expectedVariadic
     * @param FunctionSignature $actualSignature
     */
    private function assertSignature(array $expectedParameters, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $expectedReturnType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $expectedNativeReturnType, bool $expectedVariadic, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\FunctionSignature $actualSignature) : void
    {
        $this->assertCount(\count($expectedParameters), $actualSignature->getParameters());
        foreach ($expectedParameters as $i => $expectedParameter) {
            $actualParameter = $actualSignature->getParameters()[$i];
            $this->assertSame($expectedParameter['name'], $actualParameter->getName());
            $this->assertSame($expectedParameter['optional'], $actualParameter->isOptional());
            $this->assertSame($expectedParameter['type']->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $actualParameter->getType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
            $this->assertSame($expectedParameter['nativeType']->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $actualParameter->getNativeType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
            $this->assertTrue($expectedParameter['passedByReference']->equals($actualParameter->passedByReference()));
            $this->assertSame($expectedParameter['variadic'], $actualParameter->isVariadic());
        }
        $this->assertSame($expectedReturnType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $actualSignature->getReturnType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertSame($expectedNativeReturnType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $actualSignature->getNativeReturnType()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertSame($expectedVariadic, $actualSignature->isVariadic());
    }
    public function dataParseAll() : array
    {
        return \array_map(static function (string $file) : array {
            return [__DIR__ . '/../../../../vendor/phpstan/php-8-stubs/' . $file];
        }, \array_merge(\TenantCloud\BetterReflection\Relocated\PHPStan\Php8StubsMap::CLASSES, \TenantCloud\BetterReflection\Relocated\PHPStan\Php8StubsMap::FUNCTIONS));
    }
    /**
     * @dataProvider dataParseAll
     * @param string $stubFile
     */
    public function testParseAll(string $stubFile) : void
    {
        $parser = $this->getParser();
        $parser->parseFile($stubFile);
        $this->expectNotToPerformAssertions();
    }
}
