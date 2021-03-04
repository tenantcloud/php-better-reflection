<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\LockableTrait;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
class FooLock2Command extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command
{
    use LockableTrait;
    protected function configure()
    {
        $this->setName('foo:lock2');
    }
    protected function execute(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output)
    {
        try {
            $this->lock();
            $this->lock();
        } catch (\LogicException $e) {
            return 1;
        }
        return 2;
    }
}
