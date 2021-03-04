<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\DI\Extensions;

use TenantCloud\BetterReflection\Relocated\Nette;
use TenantCloud\BetterReflection\Relocated\Nette\DI\DynamicParameter;
/**
 * Parameters.
 */
final class ParametersExtension extends \TenantCloud\BetterReflection\Relocated\Nette\DI\CompilerExtension
{
    /** @var string[] */
    public $dynamicParams = [];
    /** @var string[][] */
    public $dynamicValidators = [];
    /** @var array */
    private $compilerConfig;
    public function __construct(array &$compilerConfig)
    {
        $this->compilerConfig =& $compilerConfig;
    }
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $params = $this->config;
        $resolver = new \TenantCloud\BetterReflection\Relocated\Nette\DI\Resolver($builder);
        $generator = new \TenantCloud\BetterReflection\Relocated\Nette\DI\PhpGenerator($builder);
        foreach ($this->dynamicParams as $key) {
            $params[$key] = \array_key_exists($key, $params) ? new \TenantCloud\BetterReflection\Relocated\Nette\DI\DynamicParameter($generator->formatPhp('($this->parameters[?] \\?\\? ?)', $resolver->completeArguments(\TenantCloud\BetterReflection\Relocated\Nette\DI\Helpers::filterArguments([$key, $params[$key]])))) : new \TenantCloud\BetterReflection\Relocated\Nette\DI\DynamicParameter(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::format('$this->parameters[?]', $key));
        }
        $builder->parameters = \TenantCloud\BetterReflection\Relocated\Nette\DI\Helpers::expand($params, $params, \true);
        // expand all except 'services'
        $slice = \array_diff_key($this->compilerConfig, ['services' => 1]);
        $slice = \TenantCloud\BetterReflection\Relocated\Nette\DI\Helpers::expand($slice, $builder->parameters);
        $this->compilerConfig = $slice + $this->compilerConfig;
    }
    public function afterCompile(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType $class)
    {
        $parameters = $this->getContainerBuilder()->parameters;
        \array_walk_recursive($parameters, function (&$val) : void {
            if ($val instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement || $val instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\DynamicParameter) {
                $val = null;
            }
        });
        $cnstr = $class->getMethod('__construct');
        $cnstr->addBody('$this->parameters += ?;', [$parameters]);
        foreach ($this->dynamicValidators as [$param, $expected]) {
            if ($param instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement) {
                continue;
            }
            $cnstr->addBody('Nette\\Utils\\Validators::assert(?, ?, ?);', [$param, $expected, 'dynamic parameter']);
        }
    }
}
