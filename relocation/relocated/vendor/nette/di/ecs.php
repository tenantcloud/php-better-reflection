<?php

/**
 * Rules for Nette Coding Standard
 * https://github.com/nette/coding-standard
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

return function (\TenantCloud\BetterReflection\Relocated\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(\PRESET_DIR . '/php71.php');
    $parameters = $containerConfigurator->parameters();
    $parameters->set('skip', [\TenantCloud\BetterReflection\Relocated\PhpCsFixer\Fixer\Basic\Psr4Fixer::class => ['tests/bootstrap.php']]);
};
