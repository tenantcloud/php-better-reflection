<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\CommandLoader;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\CommandLoader\ContainerCommandLoader;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\CommandNotFoundException;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\DependencyInjection\ServiceLocator;
class ContainerCommandLoaderTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testHas()
    {
        $loader = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\CommandLoader\ContainerCommandLoader(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\DependencyInjection\ServiceLocator(['foo-service' => function () {
            return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('foo');
        }, 'bar-service' => function () {
            return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('bar');
        }]), ['foo' => 'foo-service', 'bar' => 'bar-service']);
        $this->assertTrue($loader->has('foo'));
        $this->assertTrue($loader->has('bar'));
        $this->assertFalse($loader->has('baz'));
    }
    public function testGet()
    {
        $loader = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\CommandLoader\ContainerCommandLoader(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\DependencyInjection\ServiceLocator(['foo-service' => function () {
            return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('foo');
        }, 'bar-service' => function () {
            return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('bar');
        }]), ['foo' => 'foo-service', 'bar' => 'bar-service']);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command::class, $loader->get('foo'));
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command::class, $loader->get('bar'));
    }
    public function testGetUnknownCommandThrows()
    {
        $this->expectException(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\CommandNotFoundException::class);
        (new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\CommandLoader\ContainerCommandLoader(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\DependencyInjection\ServiceLocator([]), []))->get('unknown');
    }
    public function testGetCommandNames()
    {
        $loader = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\CommandLoader\ContainerCommandLoader(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\DependencyInjection\ServiceLocator(['foo-service' => function () {
            return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('foo');
        }, 'bar-service' => function () {
            return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('bar');
        }]), ['foo' => 'foo-service', 'bar' => 'bar-service']);
        $this->assertSame(['foo', 'bar'], $loader->getNames());
    }
}
