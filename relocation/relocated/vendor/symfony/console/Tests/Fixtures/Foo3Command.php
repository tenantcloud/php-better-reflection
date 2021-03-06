<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
class Foo3Command extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this->setName('foo3:bar')->setDescription('The foo3:bar command');
    }
    protected function execute(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        try {
            try {
                throw new \Exception('First exception <p>this is html</p>');
            } catch (\Exception $e) {
                throw new \Exception('Second exception <comment>comment</comment>', 0, $e);
            }
        } catch (\Exception $e) {
            throw new \Exception('Third exception <fg=blue;bg=red>comment</>', 404, $e);
        }
        return 0;
    }
}
