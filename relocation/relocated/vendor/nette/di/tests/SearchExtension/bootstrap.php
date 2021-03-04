<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

require __DIR__ . '/../bootstrap.php';
$loader = new \TenantCloud\BetterReflection\Relocated\Nette\Loaders\RobotLoader();
$loader->setTempDirectory(\TenantCloud\BetterReflection\Relocated\getTempDir());
$loader->addDirectory('fixtures');
$loader->reportParseErrors(\false);
$loader->register();
function check(string $config) : array
{
    $compiler = new \TenantCloud\BetterReflection\Relocated\Nette\DI\Compiler();
    $compiler->addExtension('search', new \TenantCloud\BetterReflection\Relocated\Nette\DI\Extensions\SearchExtension(\TenantCloud\BetterReflection\Relocated\getTempDir()));
    \TenantCloud\BetterReflection\Relocated\createContainer($compiler, $config);
    $res = [];
    foreach ($compiler->getContainerBuilder()->getDefinitions() as $def) {
        if ($def->getType() !== \TenantCloud\BetterReflection\Relocated\Nette\DI\Container::class) {
            $res[$def->getType()] = $def->getTags();
        }
    }
    \ksort($res);
    return $res;
}
