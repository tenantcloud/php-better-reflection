<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\EventListener;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Psr\Log\LoggerInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Event\ConsoleErrorEvent;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Event\ConsoleTerminateEvent;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\EventListener\ErrorListener;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\ArgvInput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\ArrayInput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\Input;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
class ErrorListenerTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testOnConsoleError()
    {
        $error = new \TypeError('An error occurred');
        $logger = $this->createMock(\TenantCloud\BetterReflection\Relocated\Psr\Log\LoggerInterface::class);
        $logger->expects($this->once())->method('critical')->with('Error thrown while running command "{command}". Message: "{message}"', ['exception' => $error, 'command' => 'test:run --foo=baz buzz', 'message' => 'An error occurred']);
        $listener = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\EventListener\ErrorListener($logger);
        $listener->onConsoleError(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Event\ConsoleErrorEvent(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\ArgvInput(['console.php', 'test:run', '--foo=baz', 'buzz']), $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::class), $error, new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('test:run')));
    }
    public function testOnConsoleErrorWithNoCommandAndNoInputString()
    {
        $error = new \RuntimeException('An error occurred');
        $logger = $this->createMock(\TenantCloud\BetterReflection\Relocated\Psr\Log\LoggerInterface::class);
        $logger->expects($this->once())->method('critical')->with('An error occurred while using the console. Message: "{message}"', ['exception' => $error, 'message' => 'An error occurred']);
        $listener = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\EventListener\ErrorListener($logger);
        $listener->onConsoleError(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Event\ConsoleErrorEvent(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\EventListener\NonStringInput(), $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::class), $error));
    }
    public function testOnConsoleTerminateForNonZeroExitCodeWritesToLog()
    {
        $logger = $this->createMock(\TenantCloud\BetterReflection\Relocated\Psr\Log\LoggerInterface::class);
        $logger->expects($this->once())->method('debug')->with('Command "{command}" exited with code "{code}"', ['command' => 'test:run', 'code' => 255]);
        $listener = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\EventListener\ErrorListener($logger);
        $listener->onConsoleTerminate($this->getConsoleTerminateEvent(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\ArgvInput(['console.php', 'test:run']), 255));
    }
    public function testOnConsoleTerminateForZeroExitCodeDoesNotWriteToLog()
    {
        $logger = $this->createMock(\TenantCloud\BetterReflection\Relocated\Psr\Log\LoggerInterface::class);
        $logger->expects($this->never())->method('debug');
        $listener = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\EventListener\ErrorListener($logger);
        $listener->onConsoleTerminate($this->getConsoleTerminateEvent(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\ArgvInput(['console.php', 'test:run']), 0));
    }
    public function testGetSubscribedEvents()
    {
        $this->assertSame(['console.error' => ['onConsoleError', -128], 'console.terminate' => ['onConsoleTerminate', -128]], \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\EventListener\ErrorListener::getSubscribedEvents());
    }
    public function testAllKindsOfInputCanBeLogged()
    {
        $logger = $this->createMock(\TenantCloud\BetterReflection\Relocated\Psr\Log\LoggerInterface::class);
        $logger->expects($this->exactly(3))->method('debug')->with('Command "{command}" exited with code "{code}"', ['command' => 'test:run --foo=bar', 'code' => 255]);
        $listener = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\EventListener\ErrorListener($logger);
        $listener->onConsoleTerminate($this->getConsoleTerminateEvent(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\ArgvInput(['console.php', 'test:run', '--foo=bar']), 255));
        $listener->onConsoleTerminate($this->getConsoleTerminateEvent(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\ArrayInput(['name' => 'test:run', '--foo' => 'bar']), 255));
        $listener->onConsoleTerminate($this->getConsoleTerminateEvent(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput('test:run --foo=bar'), 255));
    }
    public function testCommandNameIsDisplayedForNonStringableInput()
    {
        $logger = $this->createMock(\TenantCloud\BetterReflection\Relocated\Psr\Log\LoggerInterface::class);
        $logger->expects($this->once())->method('debug')->with('Command "{command}" exited with code "{code}"', ['command' => 'test:run', 'code' => 255]);
        $listener = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\EventListener\ErrorListener($logger);
        $listener->onConsoleTerminate($this->getConsoleTerminateEvent($this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface::class), 255));
    }
    private function getConsoleTerminateEvent(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, $exitCode)
    {
        return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Event\ConsoleTerminateEvent(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command('test:run'), $input, $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::class), $exitCode);
    }
}
class NonStringInput extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\Input
{
    public function getFirstArgument() : ?string
    {
    }
    public function hasParameterOption($values, $onlyParams = \false) : bool
    {
    }
    public function getParameterOption($values, $default = \false, $onlyParams = \false)
    {
    }
    public function parse()
    {
    }
}
