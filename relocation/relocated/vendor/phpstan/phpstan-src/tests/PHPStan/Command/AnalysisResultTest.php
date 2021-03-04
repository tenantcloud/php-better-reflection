<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase;
final class AnalysisResultTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testErrorsAreSortedByFileNameAndLine() : void
    {
        self::assertEquals([new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('aa1', 'aaa'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('aa2', 'aaa', 10), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('aa3', 'aaa', 15), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('aa4', 'aaa', 16), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('aa5', 'aaa', 16), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('aa6', 'aaa', 16), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('bb2', 'bbb', 2), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('bb1', 'bbb', 4), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('ccc', 'ccc'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('ddd', 'ddd')], (new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult([new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('bb1', 'bbb', 4), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('bb2', 'bbb', 2), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('aa1', 'aaa'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('ddd', 'ddd'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('ccc', 'ccc'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('aa2', 'aaa', 10), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('aa3', 'aaa', 15), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('aa5', 'aaa', 16), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('aa6', 'aaa', 16), new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('aa4', 'aaa', 16)], [], [], [], \false, null, \true))->getFileSpecificErrors());
    }
}
