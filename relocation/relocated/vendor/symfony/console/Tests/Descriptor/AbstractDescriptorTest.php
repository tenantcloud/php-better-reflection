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

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\BufferedOutput;
abstract class AbstractDescriptorTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /** @dataProvider getDescribeInputArgumentTestData */
    public function testDescribeInputArgument(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument $argument, $expectedDescription)
    {
        $this->assertDescription($expectedDescription, $argument);
    }
    /** @dataProvider getDescribeInputOptionTestData */
    public function testDescribeInputOption(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption $option, $expectedDescription)
    {
        $this->assertDescription($expectedDescription, $option);
    }
    /** @dataProvider getDescribeInputDefinitionTestData */
    public function testDescribeInputDefinition(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition $definition, $expectedDescription)
    {
        $this->assertDescription($expectedDescription, $definition);
    }
    /** @dataProvider getDescribeCommandTestData */
    public function testDescribeCommand(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command $command, $expectedDescription)
    {
        $this->assertDescription($expectedDescription, $command);
    }
    /** @dataProvider getDescribeApplicationTestData */
    public function testDescribeApplication(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application $application, $expectedDescription)
    {
        // Replaces the dynamic placeholders of the command help text with a static version.
        // The placeholder %command.full_name% includes the script path that is not predictable
        // and can not be tested against.
        foreach ($application->all() as $command) {
            $command->setHelp(\str_replace('%command.full_name%', 'app/console %command.name%', $command->getHelp()));
        }
        $this->assertDescription($expectedDescription, $application);
    }
    public function getDescribeInputArgumentTestData()
    {
        return $this->getDescriptionTestData(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Descriptor\ObjectsProvider::getInputArguments());
    }
    public function getDescribeInputOptionTestData()
    {
        return $this->getDescriptionTestData(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Descriptor\ObjectsProvider::getInputOptions());
    }
    public function getDescribeInputDefinitionTestData()
    {
        return $this->getDescriptionTestData(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Descriptor\ObjectsProvider::getInputDefinitions());
    }
    public function getDescribeCommandTestData()
    {
        return $this->getDescriptionTestData(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Descriptor\ObjectsProvider::getCommands());
    }
    public function getDescribeApplicationTestData()
    {
        return $this->getDescriptionTestData(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Descriptor\ObjectsProvider::getApplications());
    }
    protected abstract function getDescriptor();
    protected abstract function getFormat();
    protected function getDescriptionTestData(array $objects)
    {
        $data = [];
        foreach ($objects as $name => $object) {
            $description = \file_get_contents(\sprintf('%s/../Fixtures/%s.%s', __DIR__, $name, $this->getFormat()));
            $data[] = [$object, $description];
        }
        return $data;
    }
    protected function assertDescription($expectedDescription, $describedObject, array $options = [])
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\BufferedOutput(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\BufferedOutput::VERBOSITY_NORMAL, \true);
        $this->getDescriptor()->describe($output, $describedObject, $options + ['raw_output' => \true]);
        $this->assertEquals(\trim($expectedDescription), \trim(\str_replace(\PHP_EOL, "\n", $output->fetch())));
    }
}
