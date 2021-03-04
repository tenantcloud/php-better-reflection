<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
final class SymfonyProcessTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testGetProcess() : void
    {
        $output = $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::class);
        $output->expects(self::once())->method('write');
        $process = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process\SymfonyProcess(['ls'], __DIR__, $output))->getProcess();
        self::assertSame('\'ls\'', $process->getCommandLine());
        self::assertSame(__DIR__, $process->getWorkingDirectory());
    }
}
