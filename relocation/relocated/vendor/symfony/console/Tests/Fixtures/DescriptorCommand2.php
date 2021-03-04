<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Fixtures;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption;
class DescriptorCommand2 extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this->setName('descriptor:command2')->setDescription('command 2 description')->setHelp('command 2 help')->addUsage('-o|--option_name <argument_name>')->addUsage('<argument_name>')->addArgument('argument_name', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::REQUIRED)->addOption('option_name', 'o', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_NONE);
    }
}
