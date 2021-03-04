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
namespace TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
/**
 * @coversDefaultClass \phpDocumentor\Reflection\Types\Collection
 */
class CollectionTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideCollections
     * @covers ::__toString
     */
    public function testCollectionStringifyCorrectly(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Collection $collection, string $expectedString) : void
    {
        $this->assertSame($expectedString, (string) $collection);
    }
    /**
     * @return mixed[]
     */
    public function provideCollections() : array
    {
        return ['simple collection' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Collection(null, new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer()), 'object<int>'], 'simple collection with key type' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Collection(null, new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer(), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_()), 'object<string,int>'], 'collection of single type using specific class' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Collection(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen('TenantCloud\\BetterReflection\\Relocated\\Foo\\Bar'), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer()), '\\Foo\\Bar<int>'], 'collection of single type with key type and using specific class' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Collection(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen('TenantCloud\\BetterReflection\\Relocated\\Foo\\Bar'), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_(), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer()), '\\Foo\\Bar<int,string>']];
    }
}
