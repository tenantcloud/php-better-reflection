<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Descriptor;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption;
/**
 * JSON descriptor.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 *
 * @internal
 */
class JsonDescriptor extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Descriptor\Descriptor
{
    /**
     * {@inheritdoc}
     */
    protected function describeInputArgument(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument $argument, array $options = [])
    {
        $this->writeData($this->getInputArgumentData($argument), $options);
    }
    /**
     * {@inheritdoc}
     */
    protected function describeInputOption(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption $option, array $options = [])
    {
        $this->writeData($this->getInputOptionData($option), $options);
    }
    /**
     * {@inheritdoc}
     */
    protected function describeInputDefinition(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition $definition, array $options = [])
    {
        $this->writeData($this->getInputDefinitionData($definition), $options);
    }
    /**
     * {@inheritdoc}
     */
    protected function describeCommand(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command $command, array $options = [])
    {
        $this->writeData($this->getCommandData($command), $options);
    }
    /**
     * {@inheritdoc}
     */
    protected function describeApplication(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application $application, array $options = [])
    {
        $describedNamespace = $options['namespace'] ?? null;
        $description = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Descriptor\ApplicationDescription($application, $describedNamespace, \true);
        $commands = [];
        foreach ($description->getCommands() as $command) {
            $commands[] = $this->getCommandData($command);
        }
        $data = [];
        if ('UNKNOWN' !== $application->getName()) {
            $data['application']['name'] = $application->getName();
            if ('UNKNOWN' !== $application->getVersion()) {
                $data['application']['version'] = $application->getVersion();
            }
        }
        $data['commands'] = $commands;
        if ($describedNamespace) {
            $data['namespace'] = $describedNamespace;
        } else {
            $data['namespaces'] = \array_values($description->getNamespaces());
        }
        $this->writeData($data, $options);
    }
    /**
     * Writes data as json.
     */
    private function writeData(array $data, array $options)
    {
        $flags = $options['json_encoding'] ?? 0;
        $this->write(\json_encode($data, $flags));
    }
    private function getInputArgumentData(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument $argument) : array
    {
        return ['name' => $argument->getName(), 'is_required' => $argument->isRequired(), 'is_array' => $argument->isArray(), 'description' => \preg_replace('/\\s*[\\r\\n]\\s*/', ' ', $argument->getDescription()), 'default' => \INF === $argument->getDefault() ? 'INF' : $argument->getDefault()];
    }
    private function getInputOptionData(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption $option) : array
    {
        return ['name' => '--' . $option->getName(), 'shortcut' => $option->getShortcut() ? '-' . \str_replace('|', '|-', $option->getShortcut()) : '', 'accept_value' => $option->acceptValue(), 'is_value_required' => $option->isValueRequired(), 'is_multiple' => $option->isArray(), 'description' => \preg_replace('/\\s*[\\r\\n]\\s*/', ' ', $option->getDescription()), 'default' => \INF === $option->getDefault() ? 'INF' : $option->getDefault()];
    }
    private function getInputDefinitionData(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition $definition) : array
    {
        $inputArguments = [];
        foreach ($definition->getArguments() as $name => $argument) {
            $inputArguments[$name] = $this->getInputArgumentData($argument);
        }
        $inputOptions = [];
        foreach ($definition->getOptions() as $name => $option) {
            $inputOptions[$name] = $this->getInputOptionData($option);
        }
        return ['arguments' => $inputArguments, 'options' => $inputOptions];
    }
    private function getCommandData(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Command\Command $command) : array
    {
        $command->getSynopsis();
        $command->mergeApplicationDefinition(\false);
        return ['name' => $command->getName(), 'usage' => \array_merge([$command->getSynopsis()], $command->getUsages(), $command->getAliases()), 'description' => $command->getDescription(), 'help' => $command->getProcessedHelp(), 'definition' => $this->getInputDefinitionData($command->getNativeDefinition()), 'hidden' => $command->isHidden()];
    }
}
