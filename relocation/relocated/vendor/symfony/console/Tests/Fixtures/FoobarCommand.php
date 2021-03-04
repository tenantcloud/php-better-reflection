<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
class FoobarCommand extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command
{
    public $input;
    public $output;
    protected function configure()
    {
        $this->setName('foobar:foo')->setDescription('The foobar:foo command');
    }
    protected function execute(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->input = $input;
        $this->output = $output;
        return 0;
    }
}
