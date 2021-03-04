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
 * @coversDefaultClass \phpDocumentor\Reflection\Types\Nullable
 */
class NullableTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getActualType
     */
    public function testNullableTypeWrapsCorrectly() : void
    {
        $realType = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_();
        $nullableString = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Nullable($realType);
        $this->assertSame($realType, $nullableString->getActualType());
    }
    /**
     * @covers ::__toString
     */
    public function testNullableStringifyCorrectly() : void
    {
        $this->assertSame('?string', (string) new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Nullable(new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\String_()));
    }
}
