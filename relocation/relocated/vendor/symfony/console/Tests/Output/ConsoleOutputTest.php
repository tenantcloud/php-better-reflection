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
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleOutput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\Output;
class ConsoleOutputTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testConstructorWithoutFormatter()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleOutput(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\Output::VERBOSITY_QUIET, \true);
        $this->assertEquals(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\Output::VERBOSITY_QUIET, $output->getVerbosity(), '__construct() takes the verbosity as its first argument');
        $this->assertNotSame($output->getFormatter(), $output->getErrorOutput()->getFormatter(), 'ErrorOutput should use it own formatter');
    }
    public function testConstructorWithFormatter()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleOutput(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\Output::VERBOSITY_QUIET, \true, $formatter = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $this->assertEquals(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\Output::VERBOSITY_QUIET, $output->getVerbosity(), '__construct() takes the verbosity as its first argument');
        $this->assertSame($formatter, $output->getFormatter());
        $this->assertSame($formatter, $output->getErrorOutput()->getFormatter(), 'Output and ErrorOutput should use the same provided formatter');
    }
    public function testSetFormatter()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleOutput();
        $outputFormatter = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter();
        $output->setFormatter($outputFormatter);
        $this->assertSame($outputFormatter, $output->getFormatter());
        $this->assertSame($outputFormatter, $output->getErrorOutput()->getFormatter());
    }
    public function testSetVerbosity()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleOutput();
        $output->setVerbosity(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\Output::VERBOSITY_VERBOSE);
        $this->assertSame(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\Output::VERBOSITY_VERBOSE, $output->getVerbosity());
    }
}
