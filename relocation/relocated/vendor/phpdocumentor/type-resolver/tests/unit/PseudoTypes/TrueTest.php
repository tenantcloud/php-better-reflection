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
 * @coversDefaultClass \phpDocumentor\Reflection\PseudoTypes\True_
 */
class TrueTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @covers ::underlyingType
     */
    public function testExposesUnderlyingType() : void
    {
        $true = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\PseudoTypes\True_();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean::class, $true->underlyingType());
    }
    /**
     * @covers ::__toString
     */
    public function testTrueStringifyCorrectly() : void
    {
        $true = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\PseudoTypes\True_();
        $this->assertSame('true', (string) $true);
    }
    /**
     * @covers \phpDocumentor\Reflection\PseudoTypes\True_
     */
    public function testCanBeInstantiatedUsingDeprecatedFqsen() : void
    {
        $true = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\True_();
        $this->assertSame('true', (string) $true);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\PseudoTypes\True_::class, $true);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\True_::class, $true);
    }
}
