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
    $parameters->set('skip', [
        // constant NULL, FALSE
        \TenantCloud\BetterReflection\Relocated\PhpCsFixer\Fixer\Casing\LowercaseConstantsFixer::class => ['src/PhpGenerator/Type.php'],
    ]);
};
