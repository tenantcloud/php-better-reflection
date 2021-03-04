<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command\Symfony;

use TenantCloud\BetterReflection\Relocated\PHPStan\Command\OutputStyle;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\StyleInterface;
/**
 * @internal
 */
class SymfonyStyle implements \TenantCloud\BetterReflection\Relocated\PHPStan\Command\OutputStyle
{
    private \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\StyleInterface $symfonyStyle;
    public function __construct(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\StyleInterface $symfonyStyle)
    {
        $this->symfonyStyle = $symfonyStyle;
    }
    public function getSymfonyStyle() : \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\StyleInterface
    {
        return $this->symfonyStyle;
    }
    public function title(string $message) : void
    {
        $this->symfonyStyle->title($message);
    }
    public function section(string $message) : void
    {
        $this->symfonyStyle->section($message);
    }
    public function listing(array $elements) : void
    {
        $this->symfonyStyle->listing($elements);
    }
    public function success(string $message) : void
    {
        $this->symfonyStyle->success($message);
    }
    public function error(string $message) : void
    {
        $this->symfonyStyle->error($message);
    }
    public function warning(string $message) : void
    {
        $this->symfonyStyle->warning($message);
    }
    public function note(string $message) : void
    {
        $this->symfonyStyle->note($message);
    }
    public function caution(string $message) : void
    {
        $this->symfonyStyle->caution($message);
    }
    public function table(array $headers, array $rows) : void
    {
        $this->symfonyStyle->table($headers, $rows);
    }
    public function newLine(int $count = 1) : void
    {
        $this->symfonyStyle->newLine($count);
    }
    public function progressStart(int $max = 0) : void
    {
        $this->symfonyStyle->progressStart($max);
    }
    public function progressAdvance(int $step = 1) : void
    {
        $this->symfonyStyle->progressAdvance($step);
    }
    public function progressFinish() : void
    {
        $this->symfonyStyle->progressFinish();
    }
}
