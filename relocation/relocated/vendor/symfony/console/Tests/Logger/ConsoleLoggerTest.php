<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Logger;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Psr\Log\InvalidArgumentException;
use TenantCloud\BetterReflection\Relocated\Psr\Log\LoggerInterface;
use TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Logger\ConsoleLogger;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\BufferedOutput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Fixtures\DummyOutput;
/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class ConsoleLoggerTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @var DummyOutput
     */
    protected $output;
    public function getLogger() : \TenantCloud\BetterReflection\Relocated\Psr\Log\LoggerInterface
    {
        $this->output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Fixtures\DummyOutput(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERBOSE);
        return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Logger\ConsoleLogger($this->output, [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::EMERGENCY => \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::ALERT => \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::CRITICAL => \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::ERROR => \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::WARNING => \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::NOTICE => \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::INFO => \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::DEBUG => \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL]);
    }
    /**
     * Return the log messages in order.
     *
     * @return string[]
     */
    public function getLogs() : array
    {
        return $this->output->getLogs();
    }
    /**
     * @dataProvider provideOutputMappingParams
     */
    public function testOutputMapping($logLevel, $outputVerbosity, $isOutput, $addVerbosityLevelMap = [])
    {
        $out = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\BufferedOutput($outputVerbosity);
        $logger = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Logger\ConsoleLogger($out, $addVerbosityLevelMap);
        $logger->log($logLevel, 'foo bar');
        $logs = $out->fetch();
        $this->assertEquals($isOutput ? "[{$logLevel}] foo bar" . \PHP_EOL : '', $logs);
    }
    public function provideOutputMappingParams()
    {
        $quietMap = [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::EMERGENCY => \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET];
        return [[\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::EMERGENCY, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true], [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::WARNING, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \true], [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::INFO, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \false], [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::DEBUG, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \false], [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::INFO, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERBOSE, \false], [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::INFO, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERY_VERBOSE, \true], [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::DEBUG, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERY_VERBOSE, \false], [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::DEBUG, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG, \true], [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::ALERT, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET, \false], [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::EMERGENCY, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET, \false], [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::ALERT, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET, \false, $quietMap], [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::EMERGENCY, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET, \true, $quietMap]];
    }
    public function testHasErrored()
    {
        $logger = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Logger\ConsoleLogger(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\BufferedOutput());
        $this->assertFalse($logger->hasErrored());
        $logger->warning('foo');
        $this->assertFalse($logger->hasErrored());
        $logger->error('bar');
        $this->assertTrue($logger->hasErrored());
    }
    public function testImplements()
    {
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\Psr\Log\LoggerInterface::class, $this->getLogger());
    }
    /**
     * @dataProvider provideLevelsAndMessages
     */
    public function testLogsAtAllLevels($level, $message)
    {
        $logger = $this->getLogger();
        $logger->{$level}($message, ['user' => 'Bob']);
        $logger->log($level, $message, ['user' => 'Bob']);
        $expected = [$level . ' message of level ' . $level . ' with context: Bob', $level . ' message of level ' . $level . ' with context: Bob'];
        $this->assertEquals($expected, $this->getLogs());
    }
    public function provideLevelsAndMessages()
    {
        return [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::EMERGENCY => [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::EMERGENCY, 'message of level emergency with context: {user}'], \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::ALERT => [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::ALERT, 'message of level alert with context: {user}'], \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::CRITICAL => [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::CRITICAL, 'message of level critical with context: {user}'], \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::ERROR => [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::ERROR, 'message of level error with context: {user}'], \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::WARNING => [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::WARNING, 'message of level warning with context: {user}'], \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::NOTICE => [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::NOTICE, 'message of level notice with context: {user}'], \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::INFO => [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::INFO, 'message of level info with context: {user}'], \TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::DEBUG => [\TenantCloud\BetterReflection\Relocated\Psr\Log\LogLevel::DEBUG, 'message of level debug with context: {user}']];
    }
    public function testThrowsOnInvalidLevel()
    {
        $this->expectException(\TenantCloud\BetterReflection\Relocated\Psr\Log\InvalidArgumentException::class);
        $logger = $this->getLogger();
        $logger->log('invalid level', 'Foo');
    }
    public function testContextReplacement()
    {
        $logger = $this->getLogger();
        $logger->info('{Message {nothing} {user} {foo.bar} a}', ['user' => 'Bob', 'foo.bar' => 'Bar']);
        $expected = ['info {Message {nothing} Bob Bar a}'];
        $this->assertEquals($expected, $this->getLogs());
    }
    public function testObjectCastToString()
    {
        if (\method_exists($this, 'createPartialMock')) {
            $dummy = $this->createPartialMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Logger\DummyTest::class, ['__toString']);
        } else {
            $dummy = $this->createPartialMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Logger\DummyTest::class, ['__toString']);
        }
        $dummy->method('__toString')->willReturn('DUMMY');
        $this->getLogger()->warning($dummy);
        $expected = ['warning DUMMY'];
        $this->assertEquals($expected, $this->getLogs());
    }
    public function testContextCanContainAnything()
    {
        $context = ['bool' => \true, 'null' => null, 'string' => 'Foo', 'int' => 0, 'float' => 0.5, 'nested' => ['with object' => new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Logger\DummyTest()], 'object' => new \DateTime(), 'resource' => \fopen('php://memory', 'r')];
        $this->getLogger()->warning('Crazy context data', $context);
        $expected = ['warning Crazy context data'];
        $this->assertEquals($expected, $this->getLogs());
    }
    public function testContextExceptionKeyCanBeExceptionOrOtherValues()
    {
        $logger = $this->getLogger();
        $logger->warning('Random message', ['exception' => 'oops']);
        $logger->critical('Uncaught Exception!', ['exception' => new \LogicException('Fail')]);
        $expected = ['warning Random message', 'critical Uncaught Exception!'];
        $this->assertEquals($expected, $this->getLogs());
    }
}
class DummyTest
{
    public function __toString() : string
    {
    }
}
