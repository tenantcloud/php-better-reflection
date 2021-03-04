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
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\InvalidOptionException;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester;
class CommandTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    protected static $fixturesPath;
    public static function setUpBeforeClass() : void
    {
        self::$fixturesPath = __DIR__ . '/../Fixtures/';
        require_once self::$fixturesPath . '/TestCommand.php';
    }
    public function testConstructor()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('foo:bar');
        $this->assertEquals('foo:bar', $command->getName(), '__construct() takes the command name as its first argument');
    }
    public function testCommandNameCannotBeEmpty()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('The command defined in "Symfony\\Component\\Console\\Command\\Command" cannot have an empty name.');
        (new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application())->add(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command());
    }
    public function testSetApplication()
    {
        $application = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application();
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setApplication($application);
        $this->assertEquals($application, $command->getApplication(), '->setApplication() sets the current application');
        $this->assertEquals($application->getHelperSet(), $command->getHelperSet());
    }
    public function testSetApplicationNull()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setApplication(null);
        $this->assertNull($command->getHelperSet());
    }
    public function testSetGetDefinition()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $ret = $command->setDefinition($definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition());
        $this->assertEquals($command, $ret, '->setDefinition() implements a fluent interface');
        $this->assertEquals($definition, $command->getDefinition(), '->setDefinition() sets the current InputDefinition instance');
        $command->setDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('bar')]);
        $this->assertTrue($command->getDefinition()->hasArgument('foo'), '->setDefinition() also takes an array of InputArguments and InputOptions as an argument');
        $this->assertTrue($command->getDefinition()->hasOption('bar'), '->setDefinition() also takes an array of InputArguments and InputOptions as an argument');
        $command->setDefinition(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition());
    }
    public function testAddArgument()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $ret = $command->addArgument('foo');
        $this->assertEquals($command, $ret, '->addArgument() implements a fluent interface');
        $this->assertTrue($command->getDefinition()->hasArgument('foo'), '->addArgument() adds an argument to the command');
    }
    public function testAddOption()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $ret = $command->addOption('foo');
        $this->assertEquals($command, $ret, '->addOption() implements a fluent interface');
        $this->assertTrue($command->getDefinition()->hasOption('foo'), '->addOption() adds an option to the command');
    }
    public function testSetHidden()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setHidden(\true);
        $this->assertTrue($command->isHidden());
    }
    public function testGetNamespaceGetNameSetName()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $this->assertEquals('namespace:name', $command->getName(), '->getName() returns the command name');
        $command->setName('foo');
        $this->assertEquals('foo', $command->getName(), '->setName() sets the command name');
        $ret = $command->setName('foobar:bar');
        $this->assertEquals($command, $ret, '->setName() implements a fluent interface');
        $this->assertEquals('foobar:bar', $command->getName(), '->setName() sets the command name');
    }
    /**
     * @dataProvider provideInvalidCommandNames
     */
    public function testInvalidCommandNames($name)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf('Command name "%s" is invalid.', $name));
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setName($name);
    }
    public function provideInvalidCommandNames()
    {
        return [[''], ['foo:']];
    }
    public function testGetSetDescription()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $this->assertEquals('description', $command->getDescription(), '->getDescription() returns the description');
        $ret = $command->setDescription('description1');
        $this->assertEquals($command, $ret, '->setDescription() implements a fluent interface');
        $this->assertEquals('description1', $command->getDescription(), '->setDescription() sets the description');
    }
    public function testGetSetHelp()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $this->assertEquals('help', $command->getHelp(), '->getHelp() returns the help');
        $ret = $command->setHelp('help1');
        $this->assertEquals($command, $ret, '->setHelp() implements a fluent interface');
        $this->assertEquals('help1', $command->getHelp(), '->setHelp() sets the help');
        $command->setHelp('');
        $this->assertEquals('', $command->getHelp(), '->getHelp() does not fall back to the description');
    }
    public function testGetProcessedHelp()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setHelp('The %command.name% command does... Example: php %command.full_name%.');
        $this->assertStringContainsString('The namespace:name command does...', $command->getProcessedHelp(), '->getProcessedHelp() replaces %command.name% correctly');
        $this->assertStringNotContainsString('%command.full_name%', $command->getProcessedHelp(), '->getProcessedHelp() replaces %command.full_name%');
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setHelp('');
        $this->assertStringContainsString('description', $command->getProcessedHelp(), '->getProcessedHelp() falls back to the description');
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setHelp('The %command.name% command does... Example: php %command.full_name%.');
        $application = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application();
        $application->add($command);
        $application->setDefaultCommand('namespace:name', \true);
        $this->assertStringContainsString('The namespace:name command does...', $command->getProcessedHelp(), '->getProcessedHelp() replaces %command.name% correctly in single command applications');
        $this->assertStringNotContainsString('%command.full_name%', $command->getProcessedHelp(), '->getProcessedHelp() replaces %command.full_name% in single command applications');
    }
    public function testGetSetAliases()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $this->assertEquals(['name'], $command->getAliases(), '->getAliases() returns the aliases');
        $ret = $command->setAliases(['name1']);
        $this->assertEquals($command, $ret, '->setAliases() implements a fluent interface');
        $this->assertEquals(['name1'], $command->getAliases(), '->setAliases() sets the aliases');
    }
    public function testSetAliasesNull()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $this->expectException(\InvalidArgumentException::class);
        $command->setAliases(null);
    }
    public function testGetSynopsis()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->addOption('foo');
        $command->addArgument('bar');
        $this->assertEquals('namespace:name [--foo] [--] [<bar>]', $command->getSynopsis(), '->getSynopsis() returns the synopsis');
    }
    public function testAddGetUsages()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->addUsage('foo1');
        $command->addUsage('foo2');
        $this->assertContains('namespace:name foo1', $command->getUsages());
        $this->assertContains('namespace:name foo2', $command->getUsages());
    }
    public function testGetHelper()
    {
        $application = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application();
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setApplication($application);
        $formatterHelper = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper();
        $this->assertEquals($formatterHelper->getName(), $command->getHelper('formatter')->getName(), '->getHelper() returns the correct helper');
    }
    public function testGetHelperWithoutHelperSet()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Cannot retrieve helper "formatter" because there is no HelperSet defined.');
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->getHelper('formatter');
    }
    public function testMergeApplicationDefinition()
    {
        $application1 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application();
        $application1->getDefinition()->addArguments([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo')]);
        $application1->getDefinition()->addOptions([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('bar')]);
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setApplication($application1);
        $command->setDefinition($definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('bar'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo')]));
        $r = new \ReflectionObject($command);
        $m = $r->getMethod('mergeApplicationDefinition');
        $m->setAccessible(\true);
        $m->invoke($command);
        $this->assertTrue($command->getDefinition()->hasArgument('foo'), '->mergeApplicationDefinition() merges the application arguments and the command arguments');
        $this->assertTrue($command->getDefinition()->hasArgument('bar'), '->mergeApplicationDefinition() merges the application arguments and the command arguments');
        $this->assertTrue($command->getDefinition()->hasOption('foo'), '->mergeApplicationDefinition() merges the application options and the command options');
        $this->assertTrue($command->getDefinition()->hasOption('bar'), '->mergeApplicationDefinition() merges the application options and the command options');
        $m->invoke($command);
        $this->assertEquals(3, $command->getDefinition()->getArgumentCount(), '->mergeApplicationDefinition() does not try to merge twice the application arguments and options');
    }
    public function testMergeApplicationDefinitionWithoutArgsThenWithArgsAddsArgs()
    {
        $application1 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application();
        $application1->getDefinition()->addArguments([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo')]);
        $application1->getDefinition()->addOptions([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('bar')]);
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setApplication($application1);
        $command->setDefinition($definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([]));
        $r = new \ReflectionObject($command);
        $m = $r->getMethod('mergeApplicationDefinition');
        $m->setAccessible(\true);
        $m->invoke($command, \false);
        $this->assertTrue($command->getDefinition()->hasOption('bar'), '->mergeApplicationDefinition(false) merges the application and the command options');
        $this->assertFalse($command->getDefinition()->hasArgument('foo'), '->mergeApplicationDefinition(false) does not merge the application arguments');
        $m->invoke($command, \true);
        $this->assertTrue($command->getDefinition()->hasArgument('foo'), '->mergeApplicationDefinition(true) merges the application arguments and the command arguments');
        $m->invoke($command);
        $this->assertEquals(2, $command->getDefinition()->getArgumentCount(), '->mergeApplicationDefinition() does not try to merge twice the application arguments');
    }
    public function testRunInteractive()
    {
        $tester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester(new \TenantCloud\BetterReflection\Relocated\TestCommand());
        $tester->execute([], ['interactive' => \true]);
        $this->assertEquals('interact called' . \PHP_EOL . 'execute called' . \PHP_EOL, $tester->getDisplay(), '->run() calls the interact() method if the input is interactive');
    }
    public function testRunNonInteractive()
    {
        $tester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester(new \TenantCloud\BetterReflection\Relocated\TestCommand());
        $tester->execute([], ['interactive' => \false]);
        $this->assertEquals('execute called' . \PHP_EOL, $tester->getDisplay(), '->run() does not call the interact() method if the input is not interactive');
    }
    public function testExecuteMethodNeedsToBeOverridden()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('You must override the execute() method in the concrete command class.');
        $command = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('foo');
        $command->run(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput(''), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput());
    }
    public function testRunWithInvalidOption()
    {
        $this->expectException(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\InvalidOptionException::class);
        $this->expectExceptionMessage('The "--bar" option does not exist.');
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $tester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($command);
        $tester->execute(['--bar' => \true]);
    }
    public function testRunWithApplication()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setApplication(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application());
        $exitCode = $command->run(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput(''), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput());
        $this->assertSame(0, $exitCode, '->run() returns an integer exit code');
    }
    public function testRunReturnsAlwaysInteger()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $this->assertSame(0, $command->run(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput(''), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput()));
    }
    public function testRunWithProcessTitle()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setApplication(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application());
        $command->setProcessTitle('foo');
        $this->assertSame(0, $command->run(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput(''), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput()));
        if (\function_exists('cli_set_process_title')) {
            if (null === @\cli_get_process_title() && 'Darwin' === \PHP_OS) {
                $this->markTestSkipped('Running "cli_get_process_title" as an unprivileged user is not supported on MacOS.');
            }
            $this->assertEquals('foo', \cli_get_process_title());
        }
    }
    public function testSetCode()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $ret = $command->setCode(function (\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) {
            $output->writeln('from the code...');
        });
        $this->assertEquals($command, $ret, '->setCode() implements a fluent interface');
        $tester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($command);
        $tester->execute([]);
        $this->assertEquals('interact called' . \PHP_EOL . 'from the code...' . \PHP_EOL, $tester->getDisplay());
    }
    public function getSetCodeBindToClosureTests()
    {
        return [[\true, 'not bound to the command'], [\false, 'bound to the command']];
    }
    /**
     * @dataProvider getSetCodeBindToClosureTests
     */
    public function testSetCodeBindToClosure($previouslyBound, $expected)
    {
        $code = createClosure();
        if ($previouslyBound) {
            $code = $code->bindTo($this);
        }
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setCode($code);
        $tester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($command);
        $tester->execute([]);
        $this->assertEquals('interact called' . \PHP_EOL . $expected . \PHP_EOL, $tester->getDisplay());
    }
    public function testSetCodeWithStaticClosure()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setCode(self::createClosure());
        $tester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($command);
        $tester->execute([]);
        $this->assertEquals('interact called' . \PHP_EOL . 'bound' . \PHP_EOL, $tester->getDisplay());
    }
    private static function createClosure()
    {
        return function (\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) {
            $output->writeln(isset($this) ? 'bound' : 'not bound');
        };
    }
    public function testSetCodeWithNonClosureCallable()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $ret = $command->setCode([$this, 'callableMethodCommand']);
        $this->assertEquals($command, $ret, '->setCode() implements a fluent interface');
        $tester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($command);
        $tester->execute([]);
        $this->assertEquals('interact called' . \PHP_EOL . 'from the code...' . \PHP_EOL, $tester->getDisplay());
    }
    public function callableMethodCommand(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $output->writeln('from the code...');
    }
    public function testSetCodeWithStaticAnonymousFunction()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\TestCommand();
        $command->setCode(static function (\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) {
            $output->writeln(isset($this) ? 'bound' : 'not bound');
        });
        $tester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($command);
        $tester->execute([]);
        $this->assertEquals('interact called' . \PHP_EOL . 'not bound' . \PHP_EOL, $tester->getDisplay());
    }
}
// In order to get an unbound closure, we should create it outside a class
// scope.
function createClosure()
{
    return function (\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) {
        $output->writeln($this instanceof \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command ? 'bound to the command' : 'not bound to the command');
    };
}
