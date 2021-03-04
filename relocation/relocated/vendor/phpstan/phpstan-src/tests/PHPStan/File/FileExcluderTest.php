<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\File;

class FileExcluderTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    /**
     * @dataProvider dataExcludeOnWindows
     * @param string $filePath
     * @param string[] $analyseExcludes
     * @param bool $isExcluded
     */
    public function testFilesAreExcludedFromAnalysingOnWindows(string $filePath, array $analyseExcludes, bool $isExcluded) : void
    {
        $this->skipIfNotOnWindows();
        $fileExcluder = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileExcluder($this->getFileHelper(), $analyseExcludes, []);
        $this->assertSame($isExcluded, $fileExcluder->isExcludedFromAnalysing($filePath));
    }
    public function dataExcludeOnWindows() : array
    {
        return [[__DIR__ . '/data/excluded-file.php', [], \false], [__DIR__ . '/data/excluded-file.php', [__DIR__], \true], [__DIR__ . '\\Foo\\data\\excluded-file.php', [__DIR__ . '/*\\/data/*'], \true], [__DIR__ . '\\data\\func-call.php', [], \false], [__DIR__ . '\\data\\parse-error.php', [__DIR__ . '/*'], \true], [__DIR__ . '\\data\\parse-error.php', [__DIR__ . '/data/?a?s?-error.?h?'], \true], [__DIR__ . '\\data\\parse-error.php', [__DIR__ . '/data/[pP]arse-[eE]rror.ph[pP]'], \true], [__DIR__ . '\\data\\parse-error.php', ['tests/PHPStan/File/data'], \true], [__DIR__ . '\\data\\parse-error.php', [__DIR__ . '/aaa'], \false], ['C:\\Temp\\data\\parse-error.php', ['C:/Temp/*'], \true], ['C:\\Data\\data\\parse-error.php', ['C:/Temp/*'], \false], ['c:\\Temp\\data\\parse-error.php', ['C:/Temp/*'], \true], ['C:\\Temp\\data\\parse-error.php', ['C:/temp/*'], \true], ['c:\\Data\\data\\parse-error.php', ['C:/Temp/*'], \false], ['c:\\etc\\phpstan\\dummy-1.php', ['c:\\etc\\phpstan\\'], \true], ['c:\\etc\\phpstan-test\\dummy-2.php', ['c:\\etc\\phpstan\\'], \false], ['c:\\etc\\phpstan-test\\dummy-2.php', ['TenantCloud\\BetterReflection\\Relocated\\c:\\etc\\phpstan'], \true]];
    }
    /**
     * @dataProvider dataExcludeOnUnix
     * @param string $filePath
     * @param string[] $analyseExcludes
     * @param bool $isExcluded
     */
    public function testFilesAreExcludedFromAnalysingOnUnix(string $filePath, array $analyseExcludes, bool $isExcluded) : void
    {
        $this->skipIfNotOnUnix();
        $fileExcluder = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileExcluder($this->getFileHelper(), $analyseExcludes, []);
        $this->assertSame($isExcluded, $fileExcluder->isExcludedFromAnalysing($filePath));
    }
    public function dataExcludeOnUnix() : array
    {
        return [[__DIR__ . '/data/excluded-file.php', [], \false], [__DIR__ . '/data/excluded-file.php', [__DIR__], \true], [__DIR__ . '/Foo/data/excluded-file.php', [__DIR__ . '/*/data/*'], \true], [__DIR__ . '/data/func-call.php', [], \false], [__DIR__ . '/data/parse-error.php', [__DIR__ . '/*'], \true], [__DIR__ . '/data/parse-error.php', [__DIR__ . '/data/?a?s?-error.?h?'], \true], [__DIR__ . '/data/parse-error.php', [__DIR__ . '/data/[pP]arse-[eE]rror.ph[pP]'], \true], [__DIR__ . '/data/parse-error.php', ['tests/PHPStan/File/data'], \true], [__DIR__ . '/data/parse-error.php', [__DIR__ . '/aaa'], \false], ['/tmp/data/parse-error.php', ['/tmp/*'], \true], ['/home/myname/data/parse-error.php', ['/tmp/*'], \false], ['/etc/phpstan/dummy-1.php', ['/etc/phpstan/'], \true], ['/etc/phpstan-test/dummy-2.php', ['/etc/phpstan/'], \false], ['/etc/phpstan-test/dummy-2.php', ['/etc/phpstan'], \true]];
    }
}
