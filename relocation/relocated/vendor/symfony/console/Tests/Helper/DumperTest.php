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
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\Dumper;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\VarDumper\Test\VarDumperTestTrait;
class DumperTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    use VarDumperTestTrait;
    public static function setUpBeforeClass() : void
    {
        \putenv('DUMP_LIGHT_ARRAY=1');
        \putenv('DUMP_COMMA_SEPARATOR=1');
    }
    public static function tearDownAfterClass() : void
    {
        \putenv('DUMP_LIGHT_ARRAY');
        \putenv('DUMP_COMMA_SEPARATOR');
    }
    /**
     * @dataProvider provideVariables
     */
    public function testInvoke($variable)
    {
        $output = $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::class);
        $output->method('isDecorated')->willReturn(\false);
        $dumper = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\Dumper($output);
        $this->assertDumpMatchesFormat($dumper($variable), $variable);
    }
    public function provideVariables()
    {
        return [[null], [\true], [\false], [1], [-1.5], ['string'], [[1, '2']], [new \stdClass()]];
    }
}
