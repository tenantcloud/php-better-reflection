<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

// The Nette Tester command-line runner can be
// invoked through the command: ../vendor/bin/tester .
if (@(!(include __DIR__ . '/../vendor/autoload.php'))) {
    echo 'Install Nette Tester using `composer install`';
    exit(1);
}
function same(string $expected, $actual) : void
{
    $expected = \str_replace(\PHP_EOL, "\n", $expected);
    \TenantCloud\BetterReflection\Relocated\Tester\Assert::same($expected, $actual);
}
function sameFile(string $file, $actual) : void
{
    \TenantCloud\BetterReflection\Relocated\same(\file_get_contents($file), $actual);
}
\TenantCloud\BetterReflection\Relocated\Tester\Environment::setup();
\date_default_timezone_set('Europe/Prague');
