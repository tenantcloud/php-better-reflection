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
 * @coversDefaultClass \phpDocumentor\Reflection\Types\ClassString
 */
class ClassStringTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideClassStrings
     * @covers ::__toString
     */
    public function testClassStringStringifyCorrectly(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ClassString $array, string $expectedString) : void
    {
        $this->assertSame($expectedString, (string) $array);
    }
    /**
     * @return mixed[]
     */
    public function provideClassStrings() : array
    {
        return ['generic clss string' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ClassString(), 'class-string'], 'typed class string' => [new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ClassString(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen('TenantCloud\\BetterReflection\\Relocated\\Foo\\Bar')), 'class-string<\\Foo\\Bar>']];
    }
}
