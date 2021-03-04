<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
class FooSameCaseLowercaseCommand extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this->setName('foo:bar')->setDescription('foo:bar command');
    }
}
