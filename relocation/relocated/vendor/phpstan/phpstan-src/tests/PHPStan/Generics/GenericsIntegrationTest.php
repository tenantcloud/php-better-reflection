<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Generics;

/**
 * @group exec
 */
class GenericsIntegrationTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\LevelsTestCase
{
    public function dataTopics() : array
    {
        return [['functions'], ['invalidReturn'], ['pick'], ['varyingAcceptor'], ['classes'], ['variance'], ['bug2574'], ['bug2577'], ['bug2620'], ['bug2622'], ['bug2627']];
    }
    public function getDataPath() : string
    {
        return __DIR__ . '/data';
    }
    public function getPhpStanExecutablePath() : string
    {
        return __DIR__ . '/../../../bin/phpstan';
    }
    public function getPhpStanConfigPath() : string
    {
        return __DIR__ . '/generics.neon';
    }
}
