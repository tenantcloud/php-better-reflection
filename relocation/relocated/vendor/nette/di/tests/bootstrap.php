<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

// The Nette Tester command-line runner can be
// invoked through the command: ../vendor/bin/tester .
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
class Notes
{
    public static $notes = [];
    public static function add($message) : void
    {
        self::$notes[] = $message;
    }
    public static function fetch() : array
    {
        $res = self::$notes;
        self::$notes = [];
        return $res;
    }
}
function createContainer($source, $config = null, $params = []) : ?\TenantCloud\BetterReflection\Relocated\Nette\DI\Container
{
    $class = 'Container' . \md5((string) \lcg_value());
    if ($source instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\ContainerBuilder) {
        $source->complete();
        $code = (new \TenantCloud\BetterReflection\Relocated\Nette\DI\PhpGenerator($source))->generate($class);
    } elseif ($source instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Compiler) {
        if (\is_string($config)) {
            $loader = new \TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Loader();
            $config = $loader->load(\is_file($config) ? $config : \TenantCloud\BetterReflection\Relocated\Tester\FileMock::create($config, 'neon'));
        }
        $code = $source->addConfig((array) $config)->setClassName($class)->compile();
    } else {
        return null;
    }
    \file_put_contents(\TenantCloud\BetterReflection\Relocated\getTempDir() . '/code.php', "<?php\n\n{$code}");
    require \TenantCloud\BetterReflection\Relocated\getTempDir() . '/code.php';
    return new $class($params);
}
