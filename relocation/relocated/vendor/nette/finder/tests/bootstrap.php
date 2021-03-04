<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

// The Nette Tester command-line runner can be
// invoked through the command: ../vendor/bin/tester .
if (@(!(include __DIR__ . '/../vendor/autoload.php'))) {
    echo 'Install Nette Tester using `composer install`';
    exit(1);
}
\TenantCloud\BetterReflection\Relocated\Tester\Environment::setup();
\date_default_timezone_set('Europe/Prague');
function test(string $title, \Closure $function)
{
    $function();
}
