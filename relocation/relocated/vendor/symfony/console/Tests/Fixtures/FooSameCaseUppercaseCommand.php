<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
class FooSameCaseUppercaseCommand extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this->setName('foo:BAR')->setDescription('foo:BAR command');
    }
}
