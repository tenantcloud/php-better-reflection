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

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
/**
 * @coversDefaultClass \phpDocumentor\Reflection\FqsenResolver
 * @covers ::<private>
 */
final class FqsenResolverTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @covers ::resolve
     */
    public function testResolveFqsen() : void
    {
        $fqsenResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\FqsenResolver();
        $context = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('', []);
        $result = $fqsenResolver->resolve('\\DocBlock', $context);
        static::assertSame('\\DocBlock', (string) $result);
    }
    /**
     * @covers ::resolve
     */
    public function testResolveFqsenWithEmoji() : void
    {
        $fqsenResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\FqsenResolver();
        $context = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('', []);
        $result = $fqsenResolver->resolve('\\My😁DocBlock', $context);
        static::assertSame('\\My😁DocBlock', (string) $result);
    }
    /**
     * @covers ::resolve
     */
    public function testResolveWithoutContext() : void
    {
        $fqsenResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\FqsenResolver();
        $result = $fqsenResolver->resolve('\\DocBlock');
        static::assertSame('\\DocBlock', (string) $result);
    }
    /**
     * @covers ::resolve
     */
    public function testResolveFromAlias() : void
    {
        $fqsenResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\FqsenResolver();
        $context = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('somens', ['ns' => 'TenantCloud\\BetterReflection\\Relocated\\some\\other\\ns']);
        $result = $fqsenResolver->resolve('ns', $context);
        static::assertSame('TenantCloud\\BetterReflection\\Relocated\\some\\other\\ns', (string) $result);
    }
    /**
     * @covers ::resolve
     */
    public function testResolveFromPartialAlias() : void
    {
        $fqsenResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\FqsenResolver();
        $context = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('somens', ['other' => 'TenantCloud\\BetterReflection\\Relocated\\some\\other']);
        $result = $fqsenResolver->resolve('TenantCloud\\BetterReflection\\Relocated\\other\\ns', $context);
        static::assertSame('TenantCloud\\BetterReflection\\Relocated\\some\\other\\ns', (string) $result);
    }
    public function testResolveThrowsExceptionWhenGarbageInputIsPassed() : void
    {
        $this->expectException('InvalidArgumentException');
        $fqsenResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\FqsenResolver();
        $context = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('', []);
        $fqsenResolver->resolve('this is complete garbage', $context);
    }
}
