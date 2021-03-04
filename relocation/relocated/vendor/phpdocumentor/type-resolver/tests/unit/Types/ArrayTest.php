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
 * @coversDefaultClass \phpDocumentor\Reflection\Types\Array_
 */
class ArrayTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideArrays
     * @covers ::__toString
     */
    public function testArrayStringifyCorrectly(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_ $array, string $expectedString) : void
    {
        $this->assertSame($expectedString, (string) $array);
    }
    /**
     * @return mixed[]
     */
    public function provideArrays() : array
    {
        return ['simple array' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_(), 'array'], 'array of mixed' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Mixed_()), 'array'], 'array of single type' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_()), 'string[]'], 'array of compound type' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Compound([new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer(), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_()])), '(int|string)[]'], 'array with key type' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Array_(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_(), new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Integer()), 'array<int,string>']];
    }
}
