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
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\ExceptionInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet;
class HelperSetTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testConstructor()
    {
        $mock_helper = $this->getGenericMockHelper('fake_helper');
        $helperset = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet(['fake_helper_alias' => $mock_helper]);
        $this->assertEquals($mock_helper, $helperset->get('fake_helper_alias'), '__construct sets given helper to helpers');
        $this->assertTrue($helperset->has('fake_helper_alias'), '__construct sets helper alias for given helper');
    }
    public function testSet()
    {
        $helperset = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet();
        $helperset->set($this->getGenericMockHelper('fake_helper', $helperset));
        $this->assertTrue($helperset->has('fake_helper'), '->set() adds helper to helpers');
        $helperset = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet();
        $helperset->set($this->getGenericMockHelper('fake_helper_01', $helperset));
        $helperset->set($this->getGenericMockHelper('fake_helper_02', $helperset));
        $this->assertTrue($helperset->has('fake_helper_01'), '->set() will set multiple helpers on consecutive calls');
        $this->assertTrue($helperset->has('fake_helper_02'), '->set() will set multiple helpers on consecutive calls');
        $helperset = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet();
        $helperset->set($this->getGenericMockHelper('fake_helper', $helperset), 'fake_helper_alias');
        $this->assertTrue($helperset->has('fake_helper'), '->set() adds helper alias when set');
        $this->assertTrue($helperset->has('fake_helper_alias'), '->set() adds helper alias when set');
    }
    public function testHas()
    {
        $helperset = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet(['fake_helper_alias' => $this->getGenericMockHelper('fake_helper')]);
        $this->assertTrue($helperset->has('fake_helper'), '->has() finds set helper');
        $this->assertTrue($helperset->has('fake_helper_alias'), '->has() finds set helper by alias');
    }
    public function testGet()
    {
        $helper_01 = $this->getGenericMockHelper('fake_helper_01');
        $helper_02 = $this->getGenericMockHelper('fake_helper_02');
        $helperset = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet(['fake_helper_01_alias' => $helper_01, 'fake_helper_02_alias' => $helper_02]);
        $this->assertEquals($helper_01, $helperset->get('fake_helper_01'), '->get() returns correct helper by name');
        $this->assertEquals($helper_01, $helperset->get('fake_helper_01_alias'), '->get() returns correct helper by alias');
        $this->assertEquals($helper_02, $helperset->get('fake_helper_02'), '->get() returns correct helper by name');
        $this->assertEquals($helper_02, $helperset->get('fake_helper_02_alias'), '->get() returns correct helper by alias');
        $helperset = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet();
        try {
            $helperset->get('foo');
            $this->fail('->get() throws InvalidArgumentException when helper not found');
        } catch (\Exception $e) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $e, '->get() throws InvalidArgumentException when helper not found');
            $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\ExceptionInterface::class, $e, '->get() throws domain specific exception when helper not found');
            $this->assertStringContainsString('The helper "foo" is not defined.', $e->getMessage(), '->get() throws InvalidArgumentException when helper not found');
        }
    }
    public function testSetCommand()
    {
        $cmd_01 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('foo');
        $cmd_02 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('bar');
        $helperset = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet();
        $helperset->setCommand($cmd_01);
        $this->assertEquals($cmd_01, $helperset->getCommand(), '->setCommand() stores given command');
        $helperset = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet();
        $helperset->setCommand($cmd_01);
        $helperset->setCommand($cmd_02);
        $this->assertEquals($cmd_02, $helperset->getCommand(), '->setCommand() overwrites stored command with consecutive calls');
    }
    public function testGetCommand()
    {
        $cmd = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('foo');
        $helperset = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet();
        $helperset->setCommand($cmd);
        $this->assertEquals($cmd, $helperset->getCommand(), '->getCommand() retrieves stored command');
    }
    public function testIteration()
    {
        $helperset = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet();
        $helperset->set($this->getGenericMockHelper('fake_helper_01', $helperset));
        $helperset->set($this->getGenericMockHelper('fake_helper_02', $helperset));
        $helpers = ['fake_helper_01', 'fake_helper_02'];
        $i = 0;
        foreach ($helperset as $helper) {
            $this->assertEquals($helpers[$i++], $helper->getName());
        }
    }
    private function getGenericMockHelper($name, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet $helperset = null)
    {
        $mock_helper = $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperInterface::class);
        $mock_helper->expects($this->any())->method('getName')->willReturn($name);
        if ($helperset) {
            $mock_helper->expects($this->any())->method('setHelperSet')->with($this->equalTo($helperset));
        }
        return $mock_helper;
    }
}
