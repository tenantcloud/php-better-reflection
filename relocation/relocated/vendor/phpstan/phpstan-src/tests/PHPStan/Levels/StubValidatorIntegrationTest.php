<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Levels;

/**
 * @group exec
 */
class StubValidatorIntegrationTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\LevelsTestCase
{
    public function dataTopics() : array
    {
        return [['stubValidator']];
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
        return __DIR__ . '/stubValidator.neon';
    }
    /**
     * @return string[]
     */
    public function getAdditionalAnalysedFiles() : array
    {
        return [__DIR__ . '/data/stubValidator/stubs.php'];
    }
}
