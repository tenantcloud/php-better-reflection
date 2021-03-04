<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Helper;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Bridge\PhpUnit\ClassExistsMock;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\Dumper;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\VarDumper\Dumper\CliDumper;
class DumperNativeFallbackTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass() : void
    {
        \TenantCloud\BetterReflection\Relocated\Symfony\Bridge\PhpUnit\ClassExistsMock::register(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\Dumper::class);
        \TenantCloud\BetterReflection\Relocated\Symfony\Bridge\PhpUnit\ClassExistsMock::withMockedClasses([\TenantCloud\BetterReflection\Relocated\Symfony\Component\VarDumper\Dumper\CliDumper::class => \false]);
    }
    public static function tearDownAfterClass() : void
    {
        \TenantCloud\BetterReflection\Relocated\Symfony\Bridge\PhpUnit\ClassExistsMock::withMockedClasses([]);
    }
    /**
     * @dataProvider provideVariables
     */
    public function testInvoke($variable, $primitiveString)
    {
        $dumper = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\Dumper($this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::class));
        $this->assertSame($primitiveString, $dumper($variable));
    }
    public function provideVariables()
    {
        return [[null, 'null'], [\true, 'true'], [\false, 'false'], [1, '1'], [-1.5, '-1.5'], ['string', '"string"'], [[1, '2'], "Array\n(\n    [0] => 1\n    [1] => 2\n)"], [new \stdClass(), "stdClass Object\n(\n)"]];
    }
}
