<?php

// The Nette Tester command-line runner can be
// invoked through the command: ../vendor/bin/tester .
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

if (@(!(include __DIR__ . '/../vendor/autoload.php'))) {
    echo 'Install Nette Tester using `composer install`';
    exit(1);
}
// configure environment
\TenantCloud\BetterReflection\Relocated\Tester\Environment::setup();
\date_default_timezone_set('Europe/Prague');
function getTempDir() : string
{
    $dir = __DIR__ . '/tmp/' . \getmypid();
    if (empty($GLOBALS['\\lock'])) {
        // garbage collector
        $GLOBALS['\\lock'] = $lock = \fopen(__DIR__ . '/lock', 'w');
        if (\rand(0, 100)) {
            \flock($lock, \LOCK_SH);
            @\mkdir(\dirname($dir));
        } elseif (\flock($lock, \LOCK_EX)) {
            \TenantCloud\BetterReflection\Relocated\Tester\Helpers::purge(\dirname($dir));
        }
        @\mkdir($dir);
    }
    return $dir;
}
function test(string $title, \Closure $function) : void
{
    $function();
}