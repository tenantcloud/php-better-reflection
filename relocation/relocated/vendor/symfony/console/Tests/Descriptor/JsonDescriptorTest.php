<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Descriptor;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Descriptor\JsonDescriptor;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\BufferedOutput;
class JsonDescriptorTest extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Descriptor\AbstractDescriptorTest
{
    protected function getDescriptor()
    {
        return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Descriptor\JsonDescriptor();
    }
    protected function getFormat()
    {
        return 'json';
    }
    protected function assertDescription($expectedDescription, $describedObject, array $options = [])
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\BufferedOutput(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\BufferedOutput::VERBOSITY_NORMAL, \true);
        $this->getDescriptor()->describe($output, $describedObject, $options + ['raw_output' => \true]);
        $this->assertEquals(\json_decode(\trim($expectedDescription), \true), \json_decode(\trim(\str_replace(\PHP_EOL, "\n", $output->fetch())), \true));
    }
}
