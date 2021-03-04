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
class DescriptorCommand3 extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this->setName('descriptor:command3')->setDescription('command 3 description')->setHelp('command 3 help')->setHidden(\true);
    }
}
