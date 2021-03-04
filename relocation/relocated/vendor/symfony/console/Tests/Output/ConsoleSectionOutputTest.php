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
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StreamableInputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question;
class ConsoleSectionOutputTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    private $stream;
    protected function setUp() : void
    {
        $this->stream = \fopen('php://memory', 'r+', \false);
    }
    protected function tearDown() : void
    {
        $this->stream = null;
    }
    public function testClearAll()
    {
        $sections = [];
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput($this->stream, $sections, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $output->writeln('Foo' . \PHP_EOL . 'Bar');
        $output->clear();
        \rewind($output->getStream());
        $this->assertEquals('Foo' . \PHP_EOL . 'Bar' . \PHP_EOL . \sprintf("\33[%dA", 2) . "\33[0J", \stream_get_contents($output->getStream()));
    }
    public function testClearNumberOfLines()
    {
        $sections = [];
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput($this->stream, $sections, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $output->writeln("Foo\nBar\nBaz\nFooBar");
        $output->clear(2);
        \rewind($output->getStream());
        $this->assertEquals("Foo\nBar\nBaz\nFooBar" . \PHP_EOL . \sprintf("\33[%dA", 2) . "\33[0J", \stream_get_contents($output->getStream()));
    }
    public function testClearNumberOfLinesWithMultipleSections()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput($this->stream);
        $sections = [];
        $output1 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput($output->getStream(), $sections, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $output2 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput($output->getStream(), $sections, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $output2->writeln('Foo');
        $output2->writeln('Bar');
        $output2->clear(1);
        $output1->writeln('Baz');
        \rewind($output->getStream());
        $this->assertEquals('Foo' . \PHP_EOL . 'Bar' . \PHP_EOL . "\33[1A\33[0J\33[1A\33[0J" . 'Baz' . \PHP_EOL . 'Foo' . \PHP_EOL, \stream_get_contents($output->getStream()));
    }
    public function testClearPreservingEmptyLines()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput($this->stream);
        $sections = [];
        $output1 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput($output->getStream(), $sections, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $output2 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput($output->getStream(), $sections, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $output2->writeln(\PHP_EOL . 'foo');
        $output2->clear(1);
        $output1->writeln('bar');
        \rewind($output->getStream());
        $this->assertEquals(\PHP_EOL . 'foo' . \PHP_EOL . "\33[1A\33[0J\33[1A\33[0J" . 'bar' . \PHP_EOL . \PHP_EOL, \stream_get_contents($output->getStream()));
    }
    public function testOverwrite()
    {
        $sections = [];
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput($this->stream, $sections, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $output->writeln('Foo');
        $output->overwrite('Bar');
        \rewind($output->getStream());
        $this->assertEquals('Foo' . \PHP_EOL . "\33[1A\33[0JBar" . \PHP_EOL, \stream_get_contents($output->getStream()));
    }
    public function testOverwriteMultipleLines()
    {
        $sections = [];
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput($this->stream, $sections, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $output->writeln('Foo' . \PHP_EOL . 'Bar' . \PHP_EOL . 'Baz');
        $output->overwrite('Bar');
        \rewind($output->getStream());
        $this->assertEquals('Foo' . \PHP_EOL . 'Bar' . \PHP_EOL . 'Baz' . \PHP_EOL . \sprintf("\33[%dA", 3) . "\33[0J" . 'Bar' . \PHP_EOL, \stream_get_contents($output->getStream()));
    }
    public function testAddingMultipleSections()
    {
        $sections = [];
        new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput($this->stream, $sections, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput($this->stream, $sections, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $this->assertCount(2, $sections);
    }
    public function testMultipleSectionsOutput()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput($this->stream);
        $sections = [];
        $output1 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput($output->getStream(), $sections, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $output2 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput($output->getStream(), $sections, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $output1->writeln('Foo');
        $output2->writeln('Bar');
        $output1->overwrite('Baz');
        $output2->overwrite('Foobar');
        \rewind($output->getStream());
        $this->assertEquals('Foo' . \PHP_EOL . 'Bar' . \PHP_EOL . "\33[2A\33[0JBar" . \PHP_EOL . "\33[1A\33[0JBaz" . \PHP_EOL . 'Bar' . \PHP_EOL . "\33[1A\33[0JFoobar" . \PHP_EOL, \stream_get_contents($output->getStream()));
    }
    public function testClearSectionContainingQuestion()
    {
        $inputStream = \fopen('php://memory', 'r+', \false);
        \fwrite($inputStream, "Batman & Robin\n");
        \rewind($inputStream);
        $input = $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StreamableInputInterface::class);
        $input->expects($this->once())->method('isInteractive')->willReturn(\true);
        $input->expects($this->once())->method('getStream')->willReturn($inputStream);
        $sections = [];
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleSectionOutput($this->stream, $sections, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        (new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper())->ask($input, $output, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('What\'s your favorite super hero?'));
        $output->clear();
        \rewind($output->getStream());
        $this->assertSame('What\'s your favorite super hero?' . \PHP_EOL . "\33[2A\33[0J", \stream_get_contents($output->getStream()));
    }
}
