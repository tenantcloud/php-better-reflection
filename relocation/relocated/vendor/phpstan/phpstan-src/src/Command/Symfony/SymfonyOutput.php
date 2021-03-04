<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony;

use TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\OutputStyle;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
/**
 * @internal
 */
class SymfonyOutput implements \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output
{
    private \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $symfonyOutput;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Command\OutputStyle $style;
    public function __construct(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $symfonyOutput, \TenantCloud\BetterReflection\Relocated\PHPStan\Command\OutputStyle $style)
    {
        $this->symfonyOutput = $symfonyOutput;
        $this->style = $style;
    }
    public function writeFormatted(string $message) : void
    {
        $this->symfonyOutput->write($message, \false, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::OUTPUT_NORMAL);
    }
    public function writeLineFormatted(string $message) : void
    {
        $this->symfonyOutput->writeln($message, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::OUTPUT_NORMAL);
    }
    public function writeRaw(string $message) : void
    {
        $this->symfonyOutput->write($message, \false, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::OUTPUT_RAW);
    }
    public function getStyle() : \TenantCloud\BetterReflection\Relocated\PHPStan\Command\OutputStyle
    {
        return $this->style;
    }
    public function isVerbose() : bool
    {
        return $this->symfonyOutput->isVerbose();
    }
    public function isDebug() : bool
    {
        return $this->symfonyOutput->isDebug();
    }
}
