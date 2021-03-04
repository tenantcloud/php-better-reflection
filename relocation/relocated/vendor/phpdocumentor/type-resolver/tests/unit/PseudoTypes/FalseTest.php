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
namespace TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\PseudoTypes;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
/**
 * @coversDefaultClass \phpDocumentor\Reflection\PseudoTypes\False_
 */
final class FalseTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @covers ::underlyingType
     */
    public function testExposesUnderlyingType() : void
    {
        $false = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\PseudoTypes\False_();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean::class, $false->underlyingType());
    }
    /**
     * @covers ::__toString
     */
    public function testFalseStringifyCorrectly() : void
    {
        $false = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\PseudoTypes\False_();
        $this->assertSame('false', (string) $false);
    }
    /**
     * @covers \phpDocumentor\Reflection\PseudoTypes\False_
     */
    public function testCanBeInstantiatedUsingDeprecatedFqsen() : void
    {
        $false = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\False_();
        $this->assertSame('false', (string) $false);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\PseudoTypes\False_::class, $false);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\False_::class, $false);
    }
}
