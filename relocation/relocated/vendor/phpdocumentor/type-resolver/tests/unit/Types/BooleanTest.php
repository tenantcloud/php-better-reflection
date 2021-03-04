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
 * @coversDefaultClass \phpDocumentor\Reflection\Types\Boolean
 */
final class BooleanTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @covers ::__toString
     */
    public function testBooleanStringifyCorrectly() : void
    {
        $type = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean();
        $this->assertSame('bool', (string) $type);
    }
}
