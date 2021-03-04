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
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Collection;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
/**
 * @covers ::<private>
 * @coversDefaultClass \phpDocumentor\Reflection\TypeResolver
 */
class CollectionResolverTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Collection
     * @uses \phpDocumentor\Reflection\Types\String_
     *
     * @covers ::resolve
     * @covers ::__construct
     */
    public function testResolvingCollection() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('ArrayObject<string>', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Collection::class, $resolvedType);
        $this->assertSame('\\ArrayObject<string>', (string) $resolvedType);
        $this->assertEquals('\\ArrayObject', (string) $resolvedType->getFqsen());
        $valueType = $resolvedType->getValueType();
        $keyType = $resolvedType->getKeyType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $valueType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $keyType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Collection
     * @uses \phpDocumentor\Reflection\Types\String_
     *
     * @covers ::__construct
     * @covers ::resolve
     */
    public function testResolvingCollectionWithKeyType() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('ArrayObject<string[],Iterator>', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Collection::class, $resolvedType);
        $this->assertSame('\\ArrayObject<string[],\\Iterator>', (string) $resolvedType);
        $this->assertEquals('\\ArrayObject', (string) $resolvedType->getFqsen());
        $valueType = $resolvedType->getValueType();
        $keyType = $resolvedType->getKeyType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $valueType);
        $this->assertEquals('\\Iterator', (string) $valueType->getFqsen());
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $keyType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $keyType->getValueType());
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Collection
     * @uses \phpDocumentor\Reflection\Types\String_
     *
     * @covers ::__construct
     * @covers ::resolve
     */
    public function testResolvingArrayCollection() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('array<string>', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $resolvedType);
        $this->assertSame('string[]', (string) $resolvedType);
        $valueType = $resolvedType->getValueType();
        $keyType = $resolvedType->getKeyType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $valueType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $keyType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Collection
     * @uses \phpDocumentor\Reflection\Types\String_
     *
     * @covers ::__construct
     * @covers ::resolve
     */
    public function testResolvingArrayCollectionWithKey() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('array<string,object|array>', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $resolvedType);
        $this->assertSame('array<string,object|array>', (string) $resolvedType);
        $valueType = $resolvedType->getValueType();
        $keyType = $resolvedType->getKeyType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $keyType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $valueType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Collection
     * @uses \phpDocumentor\Reflection\Types\String_
     * @covers ::__construct
     * @covers ::resolve
     */
    public function testResolvingArrayCollectionWithKeyAndWhitespace() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('array<string, object|array>', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $resolvedType);
        $this->assertSame('array<string,object|array>', (string) $resolvedType);
        $valueType = $resolvedType->getValueType();
        $keyType = $resolvedType->getKeyType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $keyType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $valueType);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Collection
     * @uses \phpDocumentor\Reflection\Types\String_
     *
     * @covers ::__construct
     * @covers ::resolve
     */
    public function testResolvingArrayCollectionWithKeyAndTooManyWhitespace() : void
    {
        $this->expectException('InvalidArgumentException');
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $fixture->resolve('array<string,  object|array>', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Collection
     * @uses \phpDocumentor\Reflection\Types\String_
     *
     * @covers ::__construct
     * @covers ::resolve
     */
    public function testResolvingCollectionOfCollection() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('ArrayObject<string|integer|double,ArrayObject<DateTime>>', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Collection::class, $resolvedType);
        $this->assertSame('\\ArrayObject<string|int|float,\\ArrayObject<\\DateTime>>', (string) $resolvedType);
        $this->assertEquals('\\ArrayObject', (string) $resolvedType->getFqsen());
        $valueType = $resolvedType->getValueType();
        $collectionValueType = $valueType->getValueType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Collection::class, $valueType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Object_::class, $valueType->getValueType());
        $this->assertEquals('\\ArrayObject', (string) $valueType->getFqsen());
        $this->assertEquals('\\DateTime', (string) $collectionValueType->getFqsen());
        $keyType = $resolvedType->getKeyType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound::class, $keyType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $keyType->get(0));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer::class, $keyType->get(1));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Float_::class, $keyType->get(2));
    }
    /**
     * @covers ::__construct
     * @covers ::resolve
     */
    public function testBadArrayCollectionKey() : void
    {
        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('An array can have only integers or strings as keys');
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $fixture->resolve('array<object,string>', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
    }
    /**
     * @covers ::__construct
     * @covers ::resolve
     */
    public function testMissingStartCollection() : void
    {
        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('Unexpected collection operator "<", class name is missing');
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $fixture->resolve('<string>', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
    }
    /**
     * @covers ::__construct
     * @covers ::resolve
     */
    public function testMissingEndCollection() : void
    {
        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('Collection: ">" is missing');
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $fixture->resolve('ArrayObject<object|string', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
    }
    /**
     * @covers ::__construct
     * @covers ::resolve
     */
    public function testBadCollectionClass() : void
    {
        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('string is not a collection');
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $fixture->resolve('string<integer>', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Context
     * @uses \phpDocumentor\Reflection\Types\Compound
     * @uses \phpDocumentor\Reflection\Types\Collection
     * @uses \phpDocumentor\Reflection\Types\String_
     *
     * @covers ::__construct
     * @covers ::resolve
     */
    public function testResolvingCollectionAsArray() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
        $resolvedType = $fixture->resolve('array<string,float>', new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context(''));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_::class, $resolvedType);
        $this->assertSame('array<string,float>', (string) $resolvedType);
        $valueType = $resolvedType->getValueType();
        $keyType = $resolvedType->getKeyType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Float_::class, $valueType);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_::class, $keyType);
    }
}
