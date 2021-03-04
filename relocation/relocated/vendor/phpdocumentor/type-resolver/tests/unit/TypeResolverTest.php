<?php

declare (strict_types=1);
/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */
namespace TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ClassString;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Expression;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Intersection;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Iterable_;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Null_;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Nullable;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use stdClass;
use function get_class;
/**
 * @coversDefaultClass \phpDocumentor\Reflection\TypeResolver
 */
class TypeResolverTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @uses         \phpDocumentor\Reflection\Types\Context
     * @uses         \phpDocumentor\Reflection\Types\Array_
     * @uses         \phpDocumentor\Reflection\Types\Object_
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     *
     * @dataProvider provideKeywords
     */
    public function testResolvingKeywords(string $keyword, string $expectedClass) : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve($keyword, new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf($expectedClass, $resolvedType);
    }
    /**
     * @uses         \phpDocumentor\Reflection\Types\Context
     * @uses         \phpDocumentor\Reflection\Types\Object_
     * @uses         \phpDocumentor\Reflection\Types\String_
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     *
     * @dataProvider provideClassStrings
     */
    public function testResolvingClassStrings(string $classString, bool $throwsException) : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        if ($throwsException) {
            $this->expectException('RuntimeException');
        }
        $resolvedType = $fixture->resolve($classString, new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ClassString::class, $resolvedType);
    }
    /**
     * @uses         \phpDocumentor\Reflection\Types\Context
     * @uses         \phpDocumentor\Reflection\Types\Object_
     * @uses         \phpDocumentor\Reflection\Fqsen
     * @uses         \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     *
     * @dataProvider provideFqcn
     */
    public function testResolvingFQSENs(string $fqsen) : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve($fqsen, new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $resolvedType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen::class, $resolvedType->getFqsen());
        $this->assertSame($fqsen, (string) $resolvedType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Object_
     * @uses \phpDocumentor\Reflection\Fqsen
     * @uses \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingRelativeQSENsBasedOnNamespace() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('DocBlock', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('TenantCloud\\BetterReflection\\Relocated\\phpDocumentor\\Reflection'));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $resolvedType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen::class, $resolvedType->getFqsen());
        $this->assertSame('TenantCloud\\BetterReflection\\Relocated\\phpDocumentor\\Reflection\\DocBlock', (string) $resolvedType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Object_
     * @uses \phpDocumentor\Reflection\Fqsen
     * @uses \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingRelativeQSENsBasedOnNamespaceAlias() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('TenantCloud\\BetterReflection\\Relocated\\m\\Array_', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('TenantCloud\\BetterReflection\\Relocated\\phpDocumentor\\Reflection', ['m' => 'TenantCloud\\BetterReflection\\Relocated\\phpDocumentor\\Reflection\\Types']));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $resolvedType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen::class, $resolvedType->getFqsen());
        $this->assertSame('TenantCloud\\BetterReflection\\Relocated\\phpDocumentor\\Reflection\\Types\\Array_', (string) $resolvedType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Array_
     * @uses \phpDocumentor\Reflection\Types\String_
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingTypedArrays() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('string[]', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $resolvedType);
        $this->assertSame('string[]', (string) $resolvedType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $resolvedType->getKeyType());
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $resolvedType->getValueType());
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Nullable
     * @uses \phpDocumentor\Reflection\Types\String_
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingNullableTypes() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('?string', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Nullable::class, $resolvedType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $resolvedType->getActualType());
        $this->assertSame('?string', (string) $resolvedType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Array_
     * @uses \phpDocumentor\Reflection\Types\String_
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingNestedTypedArrays() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('string[][]', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $childValueType = $resolvedType->getValueType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $resolvedType);
        $this->assertSame('string[][]', (string) $resolvedType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $resolvedType->getKeyType());
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $childValueType);
        $this->assertSame('string[]', (string) $childValueType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $childValueType->getKeyType());
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $childValueType->getValueType());
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\String_
     * @uses \phpDocumentor\Reflection\Types\Object_
     * @uses \phpDocumentor\Reflection\Fqsen
     * @uses \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingCompoundTypes() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('TenantCloud\\BetterReflection\\Relocated\\string|Reflection\\DocBlock', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('phpDocumentor'));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $resolvedType);
        $this->assertSame('TenantCloud\\BetterReflection\\Relocated\\string|\\phpDocumentor\\Reflection\\DocBlock', (string) $resolvedType);
        $firstType = $resolvedType->get(0);
        $secondType = $resolvedType->get(1);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $firstType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $secondType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen::class, $secondType->getFqsen());
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\String_
     * @uses \phpDocumentor\Reflection\Types\Object_
     * @uses \phpDocumentor\Reflection\Fqsen
     * @uses \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingAmpersandCompoundTypes() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('Reflection\\DocBlock&\\PHPUnit\\Framework\\MockObject\\MockObject ', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('phpDocumentor'));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Intersection::class, $resolvedType);
        $this->assertSame('TenantCloud\\BetterReflection\\Relocated\\phpDocumentor\\Reflection\\DocBlock&\\PHPUnit\\Framework\\MockObject\\MockObject', (string) $resolvedType);
        $firstType = $resolvedType->get(0);
        $secondType = $resolvedType->get(1);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $firstType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen::class, $firstType->getFqsen());
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $secondType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen::class, $secondType->getFqsen());
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\String_
     * @uses \phpDocumentor\Reflection\Types\Object_
     * @uses \phpDocumentor\Reflection\Fqsen
     * @uses \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingMixedCompoundTypes() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('(Reflection\\DocBlock&\\PHPUnit\\Framework\\MockObject\\MockObject)|null', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('phpDocumentor'));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $resolvedType);
        $this->assertSame('(\\phpDocumentor\\Reflection\\DocBlock&\\PHPUnit\\Framework\\MockObject\\MockObject)|null', (string) $resolvedType);
        $firstType = $resolvedType->get(0);
        $secondType = $resolvedType->get(1);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Expression::class, $firstType);
        $this->assertSame('(\\phpDocumentor\\Reflection\\DocBlock&\\PHPUnit\\Framework\\MockObject\\MockObject)', (string) $firstType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Null_::class, $secondType);
        $resolvedType = $firstType->getValueType();
        $firstSubType = $resolvedType->get(0);
        $secondSubType = $resolvedType->get(1);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $firstSubType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen::class, $secondSubType->getFqsen());
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $secondSubType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen::class, $secondSubType->getFqsen());
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Array_
     * @uses \phpDocumentor\Reflection\Types\Object_
     * @uses \phpDocumentor\Reflection\Fqsen
     * @uses \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingCompoundTypedArrayTypes() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('\\stdClass[]|Reflection\\DocBlock[]', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('phpDocumentor'));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $resolvedType);
        $this->assertSame('\\stdClass[]|\\phpDocumentor\\Reflection\\DocBlock[]', (string) $resolvedType);
        $firstType = $resolvedType->get(0);
        $secondType = $resolvedType->get(1);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $firstType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $secondType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $firstType->getValueType());
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $secondType->getValueType());
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\String_
     * @uses \phpDocumentor\Reflection\Types\Nullable
     * @uses \phpDocumentor\Reflection\Types\Null_
     * @uses \phpDocumentor\Reflection\Types\Boolean
     * @uses \phpDocumentor\Reflection\Fqsen
     * @uses \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingNullableCompoundTypes() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('?string|null|?boolean');
        $this->assertSame('?string|null|?bool', (string) $resolvedType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Array_
     * @uses \phpDocumentor\Reflection\Types\Object_
     * @uses \phpDocumentor\Reflection\Fqsen
     * @uses \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingArrayExpressionObjectsTypes() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('(\\stdClass|Reflection\\DocBlock)[]', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('phpDocumentor'));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $resolvedType);
        $this->assertSame('(\\stdClass|\\phpDocumentor\\Reflection\\DocBlock)[]', (string) $resolvedType);
        $valueType = $resolvedType->getValueType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $valueType);
        $firstType = $valueType->get(0);
        $secondType = $valueType->get(1);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $firstType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $secondType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Array_
     * @uses \phpDocumentor\Reflection\Types\Object_
     * @uses \phpDocumentor\Reflection\Fqsen
     * @uses \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingArrayExpressionSimpleTypes() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('(string|\\stdClass|boolean)[]', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $resolvedType);
        $this->assertSame('(string|\\stdClass|bool)[]', (string) $resolvedType);
        $valueType = $resolvedType->getValueType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $valueType);
        $firstType = $valueType->get(0);
        $secondType = $valueType->get(1);
        $thirdType = $valueType->get(2);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $firstType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $secondType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean::class, $thirdType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Array_
     * @uses \phpDocumentor\Reflection\Types\Object_
     * @uses \phpDocumentor\Reflection\Fqsen
     * @uses \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingArrayOfArrayExpressionTypes() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('(string|\\stdClass)[][]', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $resolvedType);
        $this->assertSame('(string|\\stdClass)[][]', (string) $resolvedType);
        $parentArrayType = $resolvedType->getValueType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $parentArrayType);
        $valueType = $parentArrayType->getValueType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $valueType);
        $firstType = $valueType->get(0);
        $secondType = $valueType->get(1);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $firstType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $secondType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Array_
     * @uses \phpDocumentor\Reflection\Types\Object_
     * @uses \phpDocumentor\Reflection\Fqsen
     * @uses \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testReturnEmptyCompoundOnAnUnclosedArrayExpressionType() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('(string|\\stdClass', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $resolvedType);
        $this->assertSame('', (string) $resolvedType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Array_
     * @uses \phpDocumentor\Reflection\Types\Object_
     * @uses \phpDocumentor\Reflection\Fqsen
     * @uses \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingArrayExpressionOrCompoundTypes() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('\\stdClass|(string|\\stdClass)[]|bool', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $resolvedType);
        $this->assertSame('\\stdClass|(string|\\stdClass)[]|bool', (string) $resolvedType);
        $firstType = $resolvedType->get(0);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $firstType);
        $secondType = $resolvedType->get(1);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $secondType);
        $thirdType = $resolvedType->get(2);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean::class, $thirdType);
        $valueType = $secondType->getValueType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $valueType);
        $firstArrayType = $valueType->get(0);
        $secondArrayType = $valueType->get(1);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $firstArrayType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $secondArrayType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Iterable_
     * @uses \phpDocumentor\Reflection\Types\Object_
     * @uses \phpDocumentor\Reflection\Fqsen
     * @uses \phpDocumentor\Reflection\FqsenResolver
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingIterableExpressionSimpleTypes() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('iterable<string|\\stdClass|boolean>', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Iterable_::class, $resolvedType);
        $this->assertSame('iterable<string|\\stdClass|bool>', (string) $resolvedType);
        $valueType = $resolvedType->getValueType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $valueType);
        $firstType = $valueType->get(0);
        $secondType = $valueType->get(1);
        $thirdType = $valueType->get(2);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $firstType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $secondType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean::class, $thirdType);
    }
    /**
     * This test asserts that the parameter order is correct.
     *
     * When you pass two arrays separated by the compound operator (i.e. 'integer[]|string[]') then we always split the
     * expression in its compound parts and then we parse the types with the array operators. If we were to switch the
     * order around then 'integer[]|string[]' would read as an array of string or integer array; which is something
     * other than what we intend.
     *
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Array_
     * @uses \phpDocumentor\Reflection\Types\Integer
     * @uses \phpDocumentor\Reflection\Types\String_
     *
     * @covers ::__construct
     * @covers ::resolve
     * @covers ::<private>
     */
    public function testResolvingCompoundTypesWithTwoArrays() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('integer[]|string[]', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $resolvedType);
        $this->assertSame('int[]|string[]', (string) $resolvedType);
        $firstType = $resolvedType->get(0);
        $secondType = $resolvedType->get(1);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $firstType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer::class, $firstType->getValueType());
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $secondType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $secondType->getValueType());
    }
    /**
     * @uses \phpDocumentor\Reflection\TypeResolver::resolve
     * @uses \phpDocumentor\Reflection\TypeResolver::<private>
     * @uses \phpDocumentor\Reflection\Types\Context
     *
     * @covers ::__construct
     * @covers ::addKeyword
     */
    public function testAddingAKeyword() : void
    {
        // Assign
        $typeMock = self::createStub(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type::class);
        // Act
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $fixture->addKeyword('mock', \get_class($typeMock));
        // Assert
        $result = $fixture->resolve('mock', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\get_class($typeMock), $result);
        $this->assertNotSame($typeMock, $result);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     *
     * @covers ::__construct
     * @covers ::addKeyword
     */
    public function testAddingAKeywordFailsIfTypeClassDoesNotExist() : void
    {
        $this->expectException('InvalidArgumentException');
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $fixture->addKeyword('mock', 'IDoNotExist');
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     *
     * @covers ::__construct
     * @covers ::addKeyword
     */
    public function testAddingAKeywordFailsIfTypeClassDoesNotImplementTypeInterface() : void
    {
        $this->expectException('InvalidArgumentException');
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $fixture->addKeyword('mock', \stdClass::class);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     *
     * @covers ::__construct
     * @covers ::resolve
     */
    public function testExceptionIsThrownIfTypeIsEmpty() : void
    {
        $this->expectException('InvalidArgumentException');
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $fixture->resolve(' ', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
    }
    /**
     * Returns a list of keywords and expected classes that are created from them.
     *
     * @return string[][]
     */
    public function provideKeywords() : array
    {
        return [['string', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class], ['class-string', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ClassString::class], ['int', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer::class], ['integer', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer::class], ['float', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Float_::class], ['double', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Float_::class], ['bool', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean::class], ['boolean', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean::class], ['true', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean::class], ['true', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\PseudoTypes\True_::class], ['false', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean::class], ['false', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\PseudoTypes\False_::class], ['resource', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Resource_::class], ['null', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Null_::class], ['callable', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Callable_::class], ['callback', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Callable_::class], ['array', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class], ['scalar', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Scalar::class], ['object', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class], ['mixed', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Mixed_::class], ['void', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Void_::class], ['$this', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\This::class], ['static', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Static_::class], ['self', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Self_::class], ['parent', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Parent_::class], ['iterable', \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Iterable_::class]];
    }
    /**
     * Returns a list of class string types and whether they throw an exception.
     *
     * @return (string|bool)[][]
     */
    public function provideClassStrings() : array
    {
        return [['class-string<\\phpDocumentor\\Reflection>', \false], ['class-string<\\phpDocumentor\\Reflection\\DocBlock>', \false], ['class-string<string>', \true]];
    }
    /**
     * Provides a list of FQSENs to test the resolution patterns with.
     *
     * @return string[][]
     */
    public function provideFqcn() : array
    {
        return ['namespace' => ['TenantCloud\\BetterReflection\\Relocated\\phpDocumentor\\Reflection'], 'class' => ['TenantCloud\\BetterReflection\\Relocated\\phpDocumentor\\Reflection\\DocBlock'], 'class with emoji' => ['\\My😁Class']];
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     *
     * @covers ::__construct
     * @covers ::resolve
     */
    public function testArrayKeyValueSpecification() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $type = $fixture->resolve('array<string,array<int,string>>', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertEquals(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_(), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer()), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_()), $type);
    }
}
