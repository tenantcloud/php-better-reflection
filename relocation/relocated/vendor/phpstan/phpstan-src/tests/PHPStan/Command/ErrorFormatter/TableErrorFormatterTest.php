<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter;

use TenantCloud\BetterReflection\Relocated\PHPStan\File\FuzzyRelativePathHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\NullRelativePathHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\ErrorFormatterTestCase;
class TableErrorFormatterTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\ErrorFormatterTestCase
{
    public function dataFormatterOutputProvider() : iterable
    {
        (yield ['No errors', 0, 0, 0, '
 [OK] No errors

']);
        (yield ['One file error', 1, 1, 0, ' ------ -----------------------------------------------------------------
  Line   folder with unicode 😃/file name with "spaces" and unicode 😃.php
 ------ -----------------------------------------------------------------
  4      Foo
 ------ -----------------------------------------------------------------

 [ERROR] Found 1 error

']);
        (yield ['One generic error', 1, 0, 1, ' -- ---------------------
     Error
 -- ---------------------
     first generic error
 -- ---------------------

 [ERROR] Found 1 error

']);
        (yield ['Multiple file errors', 1, 4, 0, ' ------ -----------------------------------------------------------------
  Line   folder with unicode 😃/file name with "spaces" and unicode 😃.php
 ------ -----------------------------------------------------------------
  2      Bar
         Bar2
  4      Foo
 ------ -----------------------------------------------------------------

 ------ ---------
  Line   foo.php
 ------ ---------
  1      Foo
  5      Bar
         Bar2
 ------ ---------

 [ERROR] Found 4 errors

']);
        (yield ['Multiple generic errors', 1, 0, 2, ' -- ----------------------
     Error
 -- ----------------------
     first generic error
     second generic error
 -- ----------------------

 [ERROR] Found 2 errors

']);
        (yield ['Multiple file, multiple generic errors', 1, 4, 2, ' ------ -----------------------------------------------------------------
  Line   folder with unicode 😃/file name with "spaces" and unicode 😃.php
 ------ -----------------------------------------------------------------
  2      Bar
         Bar2
  4      Foo
 ------ -----------------------------------------------------------------

 ------ ---------
  Line   foo.php
 ------ ---------
  1      Foo
  5      Bar
         Bar2
 ------ ---------

 -- ----------------------
     Error
 -- ----------------------
     first generic error
     second generic error
 -- ----------------------

 [ERROR] Found 6 errors

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
        $formatter = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\TableErrorFormatter(new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FuzzyRelativePathHelper(new \TenantCloud\BetterReflection\Relocated\PHPStan\File\NullRelativePathHelper(), self::DIRECTORY_PATH, [], '/'), \false);
        $this->assertSame($exitCode, $formatter->formatErrors($this->getAnalysisResult($numFileErrors, $numGenericErrors), $this->getOutput()), \sprintf('%s: response code do not match', $message));
        $this->assertEquals($expected, $this->getOutputContent(), \sprintf('%s: output do not match', $message));
    }
}
