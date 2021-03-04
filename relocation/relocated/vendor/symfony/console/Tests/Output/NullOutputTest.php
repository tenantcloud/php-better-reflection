<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Output;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\Output;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
class NullOutputTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testConstructor()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput();
        \ob_start();
        $output->write('foo');
        $buffer = \ob_get_clean();
        $this->assertSame('', $buffer, '->write() does nothing (at least nothing is printed)');
        $this->assertFalse($output->isDecorated(), '->isDecorated() returns false');
    }
    public function testVerbosity()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput();
        $this->assertSame(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET, $output->getVerbosity(), '->getVerbosity() returns VERBOSITY_QUIET for NullOutput by default');
        $output->setVerbosity(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERBOSE);
        $this->assertSame(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET, $output->getVerbosity(), '->getVerbosity() always returns VERBOSITY_QUIET for NullOutput');
    }
    public function testSetFormatter()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput();
        $outputFormatter = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter();
        $output->setFormatter($outputFormatter);
        $this->assertNotSame($outputFormatter, $output->getFormatter());
    }
    public function testSetVerbosity()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput();
        $output->setVerbosity(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\Output::VERBOSITY_NORMAL);
        $this->assertEquals(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\Output::VERBOSITY_QUIET, $output->getVerbosity());
    }
    public function testSetDecorated()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput();
        $output->setDecorated(\true);
        $this->assertFalse($output->isDecorated());
    }
    public function testIsQuiet()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput();
        $this->assertTrue($output->isQuiet());
    }
    public function testIsVerbose()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput();
        $this->assertFalse($output->isVerbose());
    }
    public function testIsVeryVerbose()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput();
        $this->assertFalse($output->isVeryVerbose());
    }
    public function testIsDebug()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput();
        $this->assertFalse($output->isDebug());
    }
}
