<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Descriptor;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Descriptor\ApplicationDescription;
final class ApplicationDescriptionTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getNamespacesProvider
     */
    public function testGetNamespaces(array $expected, array $names)
    {
        $application = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Descriptor\TestApplication();
        foreach ($names as $name) {
            $application->add(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command($name));
        }
        $this->assertSame($expected, \array_keys((new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Descriptor\ApplicationDescription($application))->getNamespaces()));
    }
    public function getNamespacesProvider()
    {
        return [[['_global'], ['foobar']], [['a', 'b'], ['b:foo', 'a:foo', 'b:bar']], [['_global', 'b', 'z', 22, 33], ['z:foo', '1', '33:foo', 'b:foo', '22:foo:bar']]];
    }
}
final class TestApplication extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application
{
    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        return [];
    }
}
