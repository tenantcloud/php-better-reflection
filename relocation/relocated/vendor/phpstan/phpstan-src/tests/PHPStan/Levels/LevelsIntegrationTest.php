<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Levels;

/**
 * @group exec
 */
class LevelsIntegrationTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\LevelsTestCase
{
    public function dataTopics() : array
    {
        return [['returnTypes'], ['acceptTypes'], ['methodCalls'], ['propertyAccesses'], ['constantAccesses'], ['variables'], ['callableCalls'], ['callableVariance'], ['arrayDimFetches'], ['clone'], ['iterable'], ['binaryOps'], ['comparison'], ['throwValues'], ['casts'], ['unreachable'], ['echo_'], ['print_'], ['stringOffsetAccess'], ['object'], ['encapsedString'], ['missingReturn'], ['arrayAccess'], ['typehints'], ['coalesce'], ['arrayDestructuring']];
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
        return __DIR__ . '/dynamicConstantNames.neon';
    }
}
