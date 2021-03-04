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
/**
 * @coversDefaultClass \phpDocumentor\Reflection\Types\Iterable_
 */
class IterableTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @covers ::__toString
     * @dataProvider provideIterables
     */
    public function testIterableStringifyCorrectly(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Iterable_ $iterable, string $expectedString) : void
    {
        $this->assertSame($expectedString, (string) $iterable);
    }
    /**
     * @return mixed[]
     */
    public function provideIterables() : array
    {
        return ['simple iterable' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Iterable_(), 'iterable'], 'iterable of mixed' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Iterable_(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Mixed_()), 'iterable'], 'iterable of single type' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Iterable_(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_()), 'iterable<string>'], 'iterable of compound type' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Iterable_(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound([new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer(), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_()])), 'iterable<int|string>'], 'iterable with key type' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Iterable_(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_(), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer()), 'iterable<int,string>']];
    }
}
