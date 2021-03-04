<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection;

use TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema;
class ParametersSchemaExtension extends \TenantCloud\BetterReflection\Relocated\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
    {
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::arrayOf(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::type(\TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement::class))->min(1);
    }
    public function loadConfiguration() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $config['__parametersSchema'] = new \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema::class);
        $builder = $this->getContainerBuilder();
        $builder->parameters['__parametersSchema'] = $this->processArgument(new \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement('schema', [new \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement('structure', [$config])]));
    }
    /**
     * @param Statement[] $statements
     * @return \Nette\Schema\Schema
     */
    private function processSchema(array $statements) : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
    {
        if (\count($statements) === 0) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $parameterSchema = null;
        foreach ($statements as $statement) {
            $processedArguments = \array_map(function ($argument) {
                return $this->processArgument($argument);
            }, $statement->arguments);
            if ($parameterSchema === null) {
                /** @var \Nette\Schema\Elements\Type|\Nette\Schema\Elements\AnyOf|\Nette\Schema\Elements\Structure $parameterSchema */
                $parameterSchema = \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::{$statement->getEntity()}(...$processedArguments);
            } else {
                $parameterSchema->{$statement->getEntity()}(...$processedArguments);
            }
        }
        $parameterSchema->required();
        return $parameterSchema;
    }
    /**
     * @param mixed $argument
     * @return mixed
     */
    private function processArgument($argument)
    {
        if ($argument instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement) {
            if ($argument->entity === 'schema') {
                $arguments = [];
                foreach ($argument->arguments as $schemaArgument) {
                    if (!$schemaArgument instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement) {
                        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException('schema() should contain another statement().');
                    }
                    $arguments[] = $schemaArgument;
                }
                if (\count($arguments) === 0) {
                    throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException('schema() should have at least one argument.');
                }
                return $this->processSchema($arguments);
            }
            return $this->processSchema([$argument]);
        } elseif (\is_array($argument)) {
            $processedArray = [];
            foreach ($argument as $key => $val) {
                $processedArray[$key] = $this->processArgument($val);
            }
            return $processedArray;
        }
        return $argument;
    }
}
