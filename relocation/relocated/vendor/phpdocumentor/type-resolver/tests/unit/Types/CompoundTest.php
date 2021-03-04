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

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TypeError;
use function iterator_to_array;
/**
 * @coversDefaultClass \phpDocumentor\Reflection\Types\Compound
 */
final class CompoundTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCompoundCannotBeConstructedFromType() : void
    {
        $this->expectException(\TypeError::class);
        new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound(['foo']);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Compound::__construct
     * @uses \phpDocumentor\Reflection\Types\Compound::has
     * @uses \phpDocumentor\Reflection\Types\Integer
     *
     * @covers ::get
     */
    public function testCompoundGetType() : void
    {
        $integer = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer();
        $this->assertSame($integer, (new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound([$integer]))->get(0));
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Compound::__construct
     * @uses \phpDocumentor\Reflection\Types\Compound::has
     *
     * @covers ::get
     */
    public function testCompoundGetNotExistingType() : void
    {
        $this->assertNull((new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound([]))->get(0));
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Compound::__construct
     * @uses \phpDocumentor\Reflection\Types\Integer
     *
     * @covers ::has
     */
    public function testCompoundHasIndex() : void
    {
        $this->assertTrue((new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound([new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer()]))->has(0));
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Compound::__construct
     *
     * @covers ::has
     */
    public function testCompoundDoesNotHasIndex() : void
    {
        $this->assertFalse((new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound([]))->has(0));
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Compound::__construct
     * @uses \phpDocumentor\Reflection\Types\Integer
     *
     * @covers ::contains
     */
    public function testCompoundContainsType() : void
    {
        $this->assertTrue((new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound([new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer()]))->contains(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer()));
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Compound::__construct
     * @uses \phpDocumentor\Reflection\Types\Integer
     * @uses \phpDocumentor\Reflection\Types\String_
     *
     * @covers ::contains
     */
    public function testCompoundDoesNotContainType() : void
    {
        $this->assertFalse((new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound([new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer()]))->contains(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_()));
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Integer
     * @uses \phpDocumentor\Reflection\Types\Boolean
     *
     * @covers ::__construct
     * @covers ::__toString
     */
    public function testCompoundCanBeConstructedAndStringifiedCorrectly() : void
    {
        $this->assertSame('int|bool', (string) new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound([new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer(), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean()]));
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Integer
     * @uses \phpDocumentor\Reflection\Types\Boolean
     *
     * @covers ::__construct
     * @covers ::__toString
     */
    public function testCompoundDoesNotContainDuplicates() : void
    {
        $compound = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound([new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer(), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer(), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean()]);
        $this->assertCount(2, \iterator_to_array($compound));
        $this->assertSame('int|bool', (string) $compound);
    }
    /**
     * @uses \phpDocumentor\Reflection\Types\Compound::__construct
     * @uses \phpDocumentor\Reflection\Types\Integer
     * @uses \phpDocumentor\Reflection\Types\Boolean
     *
     * @covers ::getIterator
     */
    public function testCompoundCanBeIterated() : void
    {
        $types = [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer(), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean()];
        foreach (new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound($types) as $index => $type) {
            $this->assertSame($types[$index], $type);
        }
    }
}
