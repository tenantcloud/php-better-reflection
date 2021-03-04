<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Console;

use TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Filesystem\Filesystem;
use TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process\Process;
use TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process\ProcessFactory;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester;
final class CompileCommandTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testCommand() : void
    {
        $filesystem = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Filesystem\Filesystem::class);
        $filesystem->expects(self::once())->method('read')->with('bar/composer.json')->willReturn('{"name":"phpstan/phpstan-src","replace":{"phpstan/phpstan": "self.version"},"require":{"php":"^7.4"},"require-dev":1,"autoload-dev":2,"autoload":{"psr-4":{"PHPStan\\\\":[3]}}}');
        $filesystem->expects(self::once())->method('write')->with('bar/composer.json', <<<EOT
{
    "name": "phpstan/phpstan",
    "require": {
        "php": "^7.1"
    },
    "require-dev": 1,
    "autoload-dev": 2,
    "autoload": {
        "psr-4": {
            "PHPStan\\\\": "src/"
        }
    }
}
EOT
);
        $process = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process\Process::class);
        $processFactory = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process\ProcessFactory::class);
        $processFactory->method('setOutput');
        $processFactory->method('create')->with(['php', 'box.phar', 'compile', '--no-parallel'], 'foo')->willReturn($process);
        $application = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application();
        $application->add(new \TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Console\CompileCommand($filesystem, $processFactory, 'foo', 'bar'));
        $command = $application->find('phpstan:compile');
        $commandTester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($command);
        $exitCode = $commandTester->execute(['command' => $command->getName()]);
        self::assertSame(0, $exitCode);
    }
}
