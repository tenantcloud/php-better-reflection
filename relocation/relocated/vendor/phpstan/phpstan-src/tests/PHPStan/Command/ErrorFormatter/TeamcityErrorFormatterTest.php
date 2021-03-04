<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter;

use TenantCloud\BetterReflection\Relocated\PHPStan\File\FuzzyRelativePathHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\NullRelativePathHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\ErrorFormatterTestCase;
class TeamcityErrorFormatterTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\ErrorFormatterTestCase
{
    public function dataFormatterOutputProvider() : iterable
    {
        (yield ['No errors', 0, 0, 0, '']);
        (yield ['One file error', 1, 1, 0, '##teamcity[inspectionType id=\'phpstan\' name=\'phpstan\' category=\'phpstan\' description=\'phpstan Inspection\']
##teamcity[inspection typeId=\'phpstan\' message=\'Foo\' file=\'folder with unicode 😃/file name with "spaces" and unicode 😃.php\' line=\'4\' SEVERITY=\'ERROR\' ignorable=\'1\' tip=\'\']
']);
        (yield ['One generic error', 1, 0, 1, '##teamcity[inspectionType id=\'phpstan\' name=\'phpstan\' category=\'phpstan\' description=\'phpstan Inspection\']
##teamcity[inspection typeId=\'phpstan\' message=\'first generic error\' file=\'.\' SEVERITY=\'ERROR\']
']);
        (yield ['Multiple file errors', 1, 4, 0, '##teamcity[inspectionType id=\'phpstan\' name=\'phpstan\' category=\'phpstan\' description=\'phpstan Inspection\']
##teamcity[inspection typeId=\'phpstan\' message=\'Bar||nBar2\' file=\'folder with unicode 😃/file name with "spaces" and unicode 😃.php\' line=\'2\' SEVERITY=\'ERROR\' ignorable=\'1\' tip=\'\']
##teamcity[inspection typeId=\'phpstan\' message=\'Foo\' file=\'folder with unicode 😃/file name with "spaces" and unicode 😃.php\' line=\'4\' SEVERITY=\'ERROR\' ignorable=\'1\' tip=\'\']
##teamcity[inspection typeId=\'phpstan\' message=\'Foo\' file=\'foo.php\' line=\'1\' SEVERITY=\'ERROR\' ignorable=\'1\' tip=\'\']
##teamcity[inspection typeId=\'phpstan\' message=\'Bar||nBar2\' file=\'foo.php\' line=\'5\' SEVERITY=\'ERROR\' ignorable=\'1\' tip=\'\']
']);
        (yield ['Multiple generic errors', 1, 0, 2, '##teamcity[inspectionType id=\'phpstan\' name=\'phpstan\' category=\'phpstan\' description=\'phpstan Inspection\']
##teamcity[inspection typeId=\'phpstan\' message=\'first generic error\' file=\'.\' SEVERITY=\'ERROR\']
##teamcity[inspection typeId=\'phpstan\' message=\'second generic error\' file=\'.\' SEVERITY=\'ERROR\']
']);
        (yield ['Multiple file, multiple generic errors', 1, 4, 2, '##teamcity[inspectionType id=\'phpstan\' name=\'phpstan\' category=\'phpstan\' description=\'phpstan Inspection\']
##teamcity[inspection typeId=\'phpstan\' message=\'Bar||nBar2\' file=\'folder with unicode 😃/file name with "spaces" and unicode 😃.php\' line=\'2\' SEVERITY=\'ERROR\' ignorable=\'1\' tip=\'\']
##teamcity[inspection typeId=\'phpstan\' message=\'Foo\' file=\'folder with unicode 😃/file name with "spaces" and unicode 😃.php\' line=\'4\' SEVERITY=\'ERROR\' ignorable=\'1\' tip=\'\']
##teamcity[inspection typeId=\'phpstan\' message=\'Foo\' file=\'foo.php\' line=\'1\' SEVERITY=\'ERROR\' ignorable=\'1\' tip=\'\']
##teamcity[inspection typeId=\'phpstan\' message=\'Bar||nBar2\' file=\'foo.php\' line=\'5\' SEVERITY=\'ERROR\' ignorable=\'1\' tip=\'\']
##teamcity[inspection typeId=\'phpstan\' message=\'first generic error\' file=\'.\' SEVERITY=\'ERROR\']
##teamcity[inspection typeId=\'phpstan\' message=\'second generic error\' file=\'.\' SEVERITY=\'ERROR\']
']);
    }
    /**
     * @dataProvider dataFormatterOutputProvider
     *
     * @param string $message
     * @param int    $exitCode
     * @param int    $numFileErrors
     * @param int    $numGenericErrors
     * @param string $expected
     */
    public function testFormatErrors(string $message, int $exitCode, int $numFileErrors, int $numGenericErrors, string $expected) : void
    {
        $relativePathHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FuzzyRelativePathHelper(new \TenantCloud\BetterReflection\Relocated\PHPStan\File\NullRelativePathHelper(), self::DIRECTORY_PATH, [], '/');
        $formatter = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\TeamcityErrorFormatter($relativePathHelper);
        $this->assertSame($exitCode, $formatter->formatErrors($this->getAnalysisResult($numFileErrors, $numGenericErrors), $this->getOutput()), \sprintf('%s: response code do not match', $message));
        $this->assertEquals($expected, $this->getOutputContent(), \sprintf('%s: output do not match', $message));
    }
}
