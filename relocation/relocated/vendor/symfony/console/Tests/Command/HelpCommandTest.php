<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Command;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\HelpCommand;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\ListCommand;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester;
class HelpCommandTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testExecuteForCommandAlias()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\HelpCommand();
        $command->setApplication(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application());
        $commandTester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($command);
        $commandTester->execute(['command_name' => 'li'], ['decorated' => \false]);
        $this->assertStringContainsString('list [options] [--] [<namespace>]', $commandTester->getDisplay(), '->execute() returns a text help for the given command alias');
        $this->assertStringContainsString('format=FORMAT', $commandTester->getDisplay(), '->execute() returns a text help for the given command alias');
        $this->assertStringContainsString('raw', $commandTester->getDisplay(), '->execute() returns a text help for the given command alias');
    }
    public function testExecuteForCommand()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\HelpCommand();
        $commandTester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($command);
        $command->setCommand(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\ListCommand());
        $commandTester->execute([], ['decorated' => \false]);
        $this->assertStringContainsString('list [options] [--] [<namespace>]', $commandTester->getDisplay(), '->execute() returns a text help for the given command');
        $this->assertStringContainsString('format=FORMAT', $commandTester->getDisplay(), '->execute() returns a text help for the given command');
        $this->assertStringContainsString('raw', $commandTester->getDisplay(), '->execute() returns a text help for the given command');
    }
    public function testExecuteForCommandWithXmlOption()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\HelpCommand();
        $commandTester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($command);
        $command->setCommand(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\ListCommand());
        $commandTester->execute(['--format' => 'xml']);
        $this->assertStringContainsString('<command', $commandTester->getDisplay(), '->execute() returns an XML help text if --xml is passed');
    }
    public function testExecuteForApplicationCommand()
    {
        $application = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application();
        $commandTester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($application->get('help'));
        $commandTester->execute(['command_name' => 'list']);
        $this->assertStringContainsString('list [options] [--] [<namespace>]', $commandTester->getDisplay(), '->execute() returns a text help for the given command');
        $this->assertStringContainsString('format=FORMAT', $commandTester->getDisplay(), '->execute() returns a text help for the given command');
        $this->assertStringContainsString('raw', $commandTester->getDisplay(), '->execute() returns a text help for the given command');
    }
    public function testExecuteForApplicationCommandWithXmlOption()
    {
        $application = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application();
        $commandTester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($application->get('help'));
        $commandTester->execute(['command_name' => 'list', '--format' => 'xml']);
        $this->assertStringContainsString('list [--raw] [--format FORMAT] [--] [&lt;namespace&gt;]', $commandTester->getDisplay(), '->execute() returns a text help for the given command');
        $this->assertStringContainsString('<command', $commandTester->getDisplay(), '->execute() returns an XML help text if --format=xml is passed');
    }
}
