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
 * @coversDefaultClass \phpDocumentor\Reflection\Types\Context
 */
class ContextTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getNamespace
     */
    public function testProvidesANormalizedNamespace() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('TenantCloud\\BetterReflection\\Relocated\\My\\Space');
        $this->assertSame('TenantCloud\\BetterReflection\\Relocated\\My\\Space', $fixture->getNamespace());
    }
    /**
     * @covers ::__construct
     * @covers ::getNamespace
     */
    public function testInterpretsNamespaceNamedGlobalAsRootNamespace() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('global');
        $this->assertSame('', $fixture->getNamespace());
    }
    /**
     * @covers ::__construct
     * @covers ::getNamespace
     */
    public function testInterpretsNamespaceNamedDefaultAsRootNamespace() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('default');
        $this->assertSame('', $fixture->getNamespace());
    }
    /**
     * @covers ::__construct
     * @covers ::getNamespaceAliases
     */
    public function testProvidesNormalizedNamespaceAliases() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('', ['Space' => 'TenantCloud\\BetterReflection\\Relocated\\My\\Space']);
        $this->assertSame(['Space' => 'TenantCloud\\BetterReflection\\Relocated\\My\\Space'], $fixture->getNamespaceAliases());
    }
}
