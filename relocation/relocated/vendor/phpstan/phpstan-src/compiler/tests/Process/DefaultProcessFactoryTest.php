<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
final class DefaultProcessFactoryTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testCreate() : void
    {
        $output = $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::class);
        $output->expects(self::once())->method('write');
        $factory = new \TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process\DefaultProcessFactory();
        $factory->setOutput($output);
        $process = $factory->create(['ls'], __DIR__)->getProcess();
        self::assertSame('\'ls\'', $process->getCommandLine());
        self::assertSame(__DIR__, $process->getWorkingDirectory());
    }
}
