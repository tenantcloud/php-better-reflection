<?php

namespace TenantCloud\BetterReflection\Relocated\Composer;

use TenantCloud\BetterReflection\Relocated\Composer\Autoload\ClassLoader;
use TenantCloud\BetterReflection\Relocated\Composer\Semver\VersionParser;
class InstalledVersions
{
    private static $installed = array('root' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => 'fa6231252a935b210cf448f0bab03e3c04cfcc67', 'name' => '__root__'), 'versions' => array('__root__' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => 'fa6231252a935b210cf448f0bab03e3c04cfcc67'), 'clue/block-react' => array('pretty_version' => 'v1.4.0', 'version' => '1.4.0.0', 'aliases' => array(), 'reference' => 'c8e7583ae55127b89d6915480ce295bac81c4f88'), 'clue/ndjson-react' => array('pretty_version' => 'v1.2.0', 'version' => '1.2.0.0', 'aliases' => array(), 'reference' => '708411c7e45ac85371a99d50f52284971494bede'), 'composer/ca-bundle' => array('pretty_version' => 'dev-main', 'version' => 'dev-main', 'aliases' => array(0 => '1.x-dev'), 'reference' => '9dea32b6bb602918b0144d4784b166cb95d45099'), 'composer/package-versions-deprecated' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '1.x-dev'), 'reference' => 'f921205948ab93bb19f86327c793a81edb62f236'), 'composer/xdebug-handler' => array('pretty_version' => '1.4.5', 'version' => '1.4.5.0', 'aliases' => array(), 'reference' => 'f28d44c286812c714741478d968104c5e604a1d4'), 'evenement/evenement' => array('pretty_version' => 'v3.0.1', 'version' => '3.0.1.0', 'aliases' => array(), 'reference' => '531bfb9d15f8aa57454f5f0285b18bec903b8fb7'), 'hoa/compiler' => array('pretty_version' => '3.17.08.08', 'version' => '3.17.08.08', 'aliases' => array(), 'reference' => 'aa09caf0bf28adae6654ca6ee415ee2f522672de'), 'hoa/consistency' => array('pretty_version' => '1.17.05.02', 'version' => '1.17.05.02', 'aliases' => array(), 'reference' => 'fd7d0adc82410507f332516faf655b6ed22e4c2f'), 'hoa/event' => array('pretty_version' => '1.17.01.13', 'version' => '1.17.01.13', 'aliases' => array(), 'reference' => '6c0060dced212ffa3af0e34bb46624f990b29c54'), 'hoa/exception' => array('pretty_version' => '1.17.01.16', 'version' => '1.17.01.16', 'aliases' => array(), 'reference' => '091727d46420a3d7468ef0595651488bfc3a458f'), 'hoa/file' => array('pretty_version' => '1.17.07.11', 'version' => '1.17.07.11', 'aliases' => array(), 'reference' => '35cb979b779bc54918d2f9a4e02ed6c7a1fa67ca'), 'hoa/iterator' => array('pretty_version' => '2.17.01.10', 'version' => '2.17.01.10', 'aliases' => array(), 'reference' => 'd1120ba09cb4ccd049c86d10058ab94af245f0cc'), 'hoa/math' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '1.x-dev'), 'reference' => 'ad9fa9081754a9768936360dba9068a4d22b97d7'), 'hoa/protocol' => array('pretty_version' => '1.17.01.14', 'version' => '1.17.01.14', 'aliases' => array(), 'reference' => '5c2cf972151c45f373230da170ea015deecf19e2'), 'hoa/regex' => array('pretty_version' => '1.17.01.13', 'version' => '1.17.01.13', 'aliases' => array(), 'reference' => '7e263a61b6fb45c1d03d8e5ef77668518abd5bec'), 'hoa/stream' => array('pretty_version' => '1.17.02.21', 'version' => '1.17.02.21', 'aliases' => array(), 'reference' => '3293cfffca2de10525df51436adf88a559151d82'), 'hoa/ustring' => array('pretty_version' => '4.17.01.16', 'version' => '4.17.01.16', 'aliases' => array(), 'reference' => 'e6326e2739178799b1fe3fdd92029f9517fa17a0'), 'hoa/visitor' => array('pretty_version' => '2.17.01.16', 'version' => '2.17.01.16', 'aliases' => array(), 'reference' => 'c18fe1cbac98ae449e0d56e87469103ba08f224a'), 'hoa/zformat' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '1.x-dev'), 'reference' => '522c381a2a075d4b9dbb42eb4592dd09520e4ac2'), 'jean85/pretty-package-versions' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '1.x-dev'), 'reference' => 'a917488320c20057da87f67d0d40543dd9427f7a'), 'jetbrains/phpstorm-stubs' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9999999-dev'), 'reference' => 'b8f79e9cb605f2855a92a8cd6aee06de3ed598a5'), 'nette/bootstrap' => array('pretty_version' => 'v3.0.2', 'version' => '3.0.2.0', 'aliases' => array(), 'reference' => '67830a65b42abfb906f8e371512d336ebfb5da93'), 'nette/di' => array('pretty_version' => 'v3.0.x-dev', 'version' => '3.0.9999999.9999999-dev', 'aliases' => array(), 'reference' => '1a3210f0f1f971db8a6e970c716c1cebd28b7ab0'), 'nette/finder' => array('pretty_version' => 'v2.5.x-dev', 'version' => '2.5.9999999.9999999-dev', 'aliases' => array(), 'reference' => '587e05b1e4729a4e87402784ba1056d671084acd'), 'nette/neon' => array('pretty_version' => 'v3.2.x-dev', 'version' => '3.2.9999999.9999999-dev', 'aliases' => array(), 'reference' => 'e4ca6f4669121ca6876b1d048c612480e39a28d5'), 'nette/php-generator' => array('pretty_version' => 'v3.5.x-dev', 'version' => '3.5.9999999.9999999-dev', 'aliases' => array(), 'reference' => '36fc0ff9c68705c4f80a9a7d28b20f6d7a9a3c89'), 'nette/robot-loader' => array('pretty_version' => 'v3.3.x-dev', 'version' => '3.3.9999999.9999999-dev', 'aliases' => array(), 'reference' => '83face2dedf6bb9b24b639c3bea660a31befc415'), 'nette/schema' => array('pretty_version' => 'v1.2.1', 'version' => '1.2.1.0', 'aliases' => array(), 'reference' => '79e01c1d488dc08f34ecb326777b029b4091bd9a'), 'nette/utils' => array('pretty_version' => 'v3.2.x-dev', 'version' => '3.2.9999999.9999999-dev', 'aliases' => array(), 'reference' => '7b2050bc28a268e3a0dd9a0b9a80fff1ba5b4cb0'), 'nikic/php-parser' => array('pretty_version' => 'v4.10.4', 'version' => '4.10.4.0', 'aliases' => array(), 'reference' => 'c6d052fc58cb876152f89f532b95a8d7907e7f0e'), 'ocramius/package-versions' => array('replaced' => array(0 => '1.11.99')), 'ondram/ci-detector' => array('pretty_version' => '3.5.1', 'version' => '3.5.1.0', 'aliases' => array(), 'reference' => '594e61252843b68998bddd48078c5058fe9028bd'), 'ondrejmirtes/better-reflection' => array('pretty_version' => '4.3.51', 'version' => '4.3.51.0', 'aliases' => array(), 'reference' => '34f2d24f6cda682b26465965bbeafb289caf3219'), 'phpdocumentor/reflection-common' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '2.x-dev'), 'reference' => 'cf8df60735d98fd18070b7cab0019ba0831e219c'), 'phpdocumentor/reflection-docblock' => array('pretty_version' => '4.3.4', 'version' => '4.3.4.0', 'aliases' => array(), 'reference' => 'da3fd972d6bafd628114f7e7e036f45944b62e9c'), 'phpdocumentor/type-resolver' => array('pretty_version' => '1.x-dev', 'version' => '1.9999999.9999999.9999999-dev', 'aliases' => array(0 => '9999999-dev'), 'reference' => '6759f2268deb9f329812679e9dcb2d0083b2a30b'), 'phpstan/php-8-stubs' => array('pretty_version' => '0.1.12', 'version' => '0.1.12.0', 'aliases' => array(), 'reference' => 'f0b95bd1f0e8b906103db0956699aca2abeb5881'), 'phpstan/phpdoc-parser' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '0.4.x-dev'), 'reference' => '2e17e4a90702d8b7ead58f4e08478a8e819ba6b8'), 'phpstan/phpstan' => array('replaced' => array(0 => '0.12.x-dev', 1 => 'dev-master')), 'phpstan/phpstan-src' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '0.12.x-dev'), 'reference' => 'd97ddee4d53fa82962452f2b9fe60c334b9149f9'), 'psr/container' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '1.1.x-dev'), 'reference' => '381524e8568e07f31d504a945b88556548c8c42e'), 'psr/http-message' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '1.0.x-dev'), 'reference' => 'efd67d1dc14a7ef4fc4e518e7dee91c271d524e4'), 'psr/http-message-implementation' => array('provided' => array(0 => '1.0')), 'psr/log' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '1.1.x-dev'), 'reference' => 'a18c1e692e02b84abbafe4856c3cd7cc6903908c'), 'psr/log-implementation' => array('provided' => array(0 => '1.0')), 'react/cache' => array('pretty_version' => 'v1.1.1', 'version' => '1.1.1.0', 'aliases' => array(), 'reference' => '4bf736a2cccec7298bdf745db77585966fc2ca7e'), 'react/child-process' => array('pretty_version' => 'v0.6.2', 'version' => '0.6.2.0', 'aliases' => array(), 'reference' => '70486012c0265264d2afa489ff32e7cdb76000d9'), 'react/dns' => array('pretty_version' => 'v1.4.0', 'version' => '1.4.0.0', 'aliases' => array(), 'reference' => '665260757171e2ab17485b44e7ffffa7acb6ca1f'), 'react/event-loop' => array('pretty_version' => 'v1.1.1', 'version' => '1.1.1.0', 'aliases' => array(), 'reference' => '6d24de090cd59cfc830263cfba965be77b563c13'), 'react/http' => array('pretty_version' => 'v1.2.0', 'version' => '1.2.0.0', 'aliases' => array(), 'reference' => 'badb0a87890e14b9cdfa3aec3ba1aafd900401ac'), 'react/promise' => array('pretty_version' => '2.x-dev', 'version' => '2.9999999.9999999.9999999-dev', 'aliases' => array(), 'reference' => 'a9752a861e21c0fe0b380c9f9e55beddc0ed7d31'), 'react/promise-stream' => array('pretty_version' => 'v1.2.0', 'version' => '1.2.0.0', 'aliases' => array(), 'reference' => '6384d8b76cf7dcc44b0bf3343fb2b2928412d1fe'), 'react/promise-timer' => array('pretty_version' => 'v1.6.0', 'version' => '1.6.0.0', 'aliases' => array(), 'reference' => 'daee9baf6ef30c43ea4c86399f828bb5f558f6e6'), 'react/socket' => array('pretty_version' => 'v1.6.0', 'version' => '1.6.0.0', 'aliases' => array(), 'reference' => 'e2b96b23a13ca9b41ab343268dbce3f8ef4d524a'), 'react/stream' => array('pretty_version' => 'v1.1.1', 'version' => '1.1.1.0', 'aliases' => array(), 'reference' => '7c02b510ee3f582c810aeccd3a197b9c2f52ff1a'), 'ringcentral/psr7' => array('pretty_version' => '1.3.0', 'version' => '1.3.0.0', 'aliases' => array(), 'reference' => '360faaec4b563958b673fb52bbe94e37f14bc686'), 'roave/signature' => array('pretty_version' => '1.1.0', 'version' => '1.1.0.0', 'aliases' => array(), 'reference' => 'c4e8a59946bad694ab5682a76e7884a9157a8a2c'), 'symfony/console' => array('pretty_version' => '4.4.x-dev', 'version' => '4.4.9999999.9999999-dev', 'aliases' => array(), 'reference' => 'c98349bda966c70d6c08b4cd8658377c94166492'), 'symfony/finder' => array('pretty_version' => '4.4.x-dev', 'version' => '4.4.9999999.9999999-dev', 'aliases' => array(), 'reference' => '2543795ab1570df588b9bbd31e1a2bd7037b94f6'), 'symfony/polyfill-ctype' => array('pretty_version' => 'dev-main', 'version' => 'dev-main', 'aliases' => array(0 => '1.22.x-dev'), 'reference' => 'c6c942b1ac76c82448322025e084cadc56048b4e'), 'symfony/polyfill-mbstring' => array('pretty_version' => 'dev-main', 'version' => 'dev-main', 'aliases' => array(0 => '1.22.x-dev'), 'reference' => '5232de97ee3b75b0360528dae24e73db49566ab1'), 'symfony/polyfill-php73' => array('pretty_version' => 'dev-main', 'version' => 'dev-main', 'aliases' => array(0 => '1.22.x-dev'), 'reference' => 'a678b42e92f86eca04b7fa4c0f6f19d097fb69e2'), 'symfony/polyfill-php80' => array('pretty_version' => 'dev-main', 'version' => 'dev-main', 'aliases' => array(0 => '1.22.x-dev'), 'reference' => 'dc3063ba22c2a1fd2f45ed856374d79114998f91'), 'symfony/service-contracts' => array('pretty_version' => 'v1.1.8', 'version' => '1.1.8.0', 'aliases' => array(), 'reference' => 'ffc7f5692092df31515df2a5ecf3b7302b3ddacf'), 'webmozart/assert' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '1.10.x-dev'), 'reference' => '4631e2c7d2d7132adac9fd84d4c1a98c10a6e049')));
    private static $canGetVendors;
    private static $installedByVendor = array();
    public static function getInstalledPackages()
    {
        $packages = array();
        foreach (self::getInstalled() as $installed) {
            $packages[] = \array_keys($installed['versions']);
        }
        if (1 === \count($packages)) {
            return $packages[0];
        }
        return \array_keys(\array_flip(\call_user_func_array('array_merge', $packages)));
    }
    public static function isInstalled($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (isset($installed['versions'][$packageName])) {
                return \true;
            }
        }
        return \false;
    }
    public static function satisfies(\TenantCloud\BetterReflection\Relocated\Composer\Semver\VersionParser $parser, $packageName, $constraint)
    {
        $constraint = $parser->parseConstraints($constraint);
        $provided = $parser->parseConstraints(self::getVersionRanges($packageName));
        return $provided->matches($constraint);
    }
    public static function getVersionRanges($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            $ranges = array();
            if (isset($installed['versions'][$packageName]['pretty_version'])) {
                $ranges[] = $installed['versions'][$packageName]['pretty_version'];
            }
            if (\array_key_exists('aliases', $installed['versions'][$packageName])) {
                $ranges = \array_merge($ranges, $installed['versions'][$packageName]['aliases']);
            }
            if (\array_key_exists('replaced', $installed['versions'][$packageName])) {
                $ranges = \array_merge($ranges, $installed['versions'][$packageName]['replaced']);
            }
            if (\array_key_exists('provided', $installed['versions'][$packageName])) {
                $ranges = \array_merge($ranges, $installed['versions'][$packageName]['provided']);
            }
            return \implode(' || ', $ranges);
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getVersion($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            if (!isset($installed['versions'][$packageName]['version'])) {
                return null;
            }
            return $installed['versions'][$packageName]['version'];
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getPrettyVersion($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            if (!isset($installed['versions'][$packageName]['pretty_version'])) {
                return null;
            }
            return $installed['versions'][$packageName]['pretty_version'];
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getReference($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            if (!isset($installed['versions'][$packageName]['reference'])) {
                return null;
            }
            return $installed['versions'][$packageName]['reference'];
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getRootPackage()
    {
        $installed = self::getInstalled();
        return $installed[0]['root'];
    }
    public static function getRawData()
    {
        return self::$installed;
    }
    public static function reload($data)
    {
        self::$installed = $data;
        self::$installedByVendor = array();
    }
    private static function getInstalled()
    {
        if (null === self::$canGetVendors) {
            self::$canGetVendors = \method_exists('TenantCloud\\BetterReflection\\Relocated\\Composer\\Autoload\\ClassLoader', 'getRegisteredLoaders');
        }
        $installed = array();
        if (self::$canGetVendors) {
            foreach (\TenantCloud\BetterReflection\Relocated\Composer\Autoload\ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
                if (isset(self::$installedByVendor[$vendorDir])) {
                    $installed[] = self::$installedByVendor[$vendorDir];
                } elseif (\is_file($vendorDir . '/composer/installed.php')) {
                    $installed[] = self::$installedByVendor[$vendorDir] = (require $vendorDir . '/composer/installed.php');
                }
            }
        }
        $installed[] = self::$installed;
        return $installed;
    }
}
