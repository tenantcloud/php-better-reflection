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

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Descriptor\MarkdownDescriptor;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Fixtures\DescriptorApplicationMbString;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Fixtures\DescriptorCommandMbString;
class MarkdownDescriptorTest extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Descriptor\AbstractDescriptorTest
{
    public function getDescribeCommandTestData()
    {
        return $this->getDescriptionTestData(\array_merge(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Descriptor\ObjectsProvider::getCommands(), ['command_mbstring' => new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Fixtures\DescriptorCommandMbString()]));
    }
    public function getDescribeApplicationTestData()
    {
        return $this->getDescriptionTestData(\array_merge(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Descriptor\ObjectsProvider::getApplications(), ['application_mbstring' => new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Fixtures\DescriptorApplicationMbString()]));
    }
    protected function getDescriptor()
    {
        return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Descriptor\MarkdownDescriptor();
    }
    protected function getFormat()
    {
        return 'md';
    }
}
