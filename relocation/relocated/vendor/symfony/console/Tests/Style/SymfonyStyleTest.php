<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Style;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\ArrayInput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleOutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester;
class SymfonyStyleTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /** @var Command */
    protected $command;
    /** @var CommandTester */
    protected $tester;
    private $colSize;
    protected function setUp() : void
    {
        $this->colSize = \getenv('COLUMNS');
        \putenv('COLUMNS=121');
        $this->command = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('sfstyle');
        $this->tester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($this->command);
    }
    protected function tearDown() : void
    {
        \putenv($this->colSize ? 'COLUMNS=' . $this->colSize : 'COLUMNS');
        $this->command = null;
        $this->tester = null;
    }
    /**
     * @dataProvider inputCommandToOutputFilesProvider
     */
    public function testOutputs($inputCommandFilepath, $outputFilepath)
    {
        $code = (require $inputCommandFilepath);
        $this->command->setCode($code);
        $this->tester->execute([], ['interactive' => \false, 'decorated' => \false]);
        $this->assertStringEqualsFile($outputFilepath, $this->tester->getDisplay(\true));
    }
    /**
     * @dataProvider inputInteractiveCommandToOutputFilesProvider
     */
    public function testInteractiveOutputs($inputCommandFilepath, $outputFilepath)
    {
        $code = (require $inputCommandFilepath);
        $this->command->setCode($code);
        $this->tester->execute([], ['interactive' => \true, 'decorated' => \false]);
        $this->assertStringEqualsFile($outputFilepath, $this->tester->getDisplay(\true));
    }
    public function inputInteractiveCommandToOutputFilesProvider()
    {
        $baseDir = __DIR__ . '/../Fixtures/Style/SymfonyStyle';
        return \array_map(null, \glob($baseDir . '/command/interactive_command_*.php'), \glob($baseDir . '/output/interactive_output_*.txt'));
    }
    public function inputCommandToOutputFilesProvider()
    {
        $baseDir = __DIR__ . '/../Fixtures/Style/SymfonyStyle';
        return \array_map(null, \glob($baseDir . '/command/command_*.php'), \glob($baseDir . '/output/output_*.txt'));
    }
    public function testGetErrorStyle()
    {
        $input = $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface::class);
        $errorOutput = $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::class);
        $errorOutput->method('getFormatter')->willReturn(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $errorOutput->expects($this->once())->method('write');
        $output = $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\ConsoleOutputInterface::class);
        $output->method('getFormatter')->willReturn(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $output->expects($this->once())->method('getErrorOutput')->willReturn($errorOutput);
        $io = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle($input, $output);
        $io->getErrorStyle()->write('');
    }
    public function testGetErrorStyleUsesTheCurrentOutputIfNoErrorOutputIsAvailable()
    {
        $output = $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::class);
        $output->method('getFormatter')->willReturn(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $style = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle($this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface::class), $output);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle::class, $style->getErrorStyle());
    }
    public function testMemoryConsumption()
    {
        $io = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\ArrayInput([]), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput());
        $str = 'teststr';
        $io->writeln($str, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle::VERBOSITY_QUIET);
        $start = \memory_get_usage();
        for ($i = 0; $i < 100; ++$i) {
            $io->writeln($str, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle::VERBOSITY_QUIET);
        }
        $this->assertSame(0, \memory_get_usage() - $start);
    }
}
