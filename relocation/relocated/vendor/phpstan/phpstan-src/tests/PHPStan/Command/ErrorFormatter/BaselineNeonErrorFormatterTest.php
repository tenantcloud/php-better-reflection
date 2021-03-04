<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter;

use TenantCloud\BetterReflection\Relocated\Nette\Neon\Neon;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\ErrorFormatterTestCase;
class BaselineNeonErrorFormatterTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\ErrorFormatterTestCase
{
    public function dataFormatterOutputProvider() : iterable
    {
        (yield ['No errors', 0, 0, 0, []]);
        (yield ['One file error', 1, 1, 0, [['message' => '#^Foo$#', 'count' => 1, 'path' => 'folder with unicode 😃/file name with "spaces" and unicode 😃.php']]]);
        (yield ['Multiple file errors', 1, 4, 0, [['message' => "#^Bar\nBar2\$#", 'count' => 1, 'path' => 'folder with unicode 😃/file name with "spaces" and unicode 😃.php'], ['message' => '#^Foo$#', 'count' => 1, 'path' => 'folder with unicode 😃/file name with "spaces" and unicode 😃.php'], ['message' => '#^Foo$#', 'count' => 1, 'path' => 'foo.php'], ['message' => "#^Bar\nBar2\$#", 'count' => 1, 'path' => 'foo.php']]]);
        (yield ['Multiple file, multiple generic errors', 1, 4, 2, [['message' => "#^Bar\nBar2\$#", 'count' => 1, 'path' => 'folder with unicode 😃/file name with "spaces" and unicode 😃.php'], ['message' => '#^Foo$#', 'count' => 1, 'path' => 'folder with unicode 😃/file name with "spaces" and unicode 😃.php'], ['message' => '#^Foo$#', 'count' => 1, 'path' => 'foo.php'], ['message' => "#^Bar\nBar2\$#", 'count' => 1, 'path' => 'foo.php']]]);
    }
    /**
     * @dataProvider dataFormatterOutputProvider
     *
     * @param string $message
     * @param int    $exitCode
     * @param int    $numFileErrors
     * @param int    $numGenericErrors
     * @param mixed[] $expected
     */
    public function testFormatErrors(string $message, int $exitCode, int $numFileErrors, int $numGenericErrors, array $expected) : void
    {
        $formatter = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\BaselineNeonErrorFormatter(new \TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper(self::DIRECTORY_PATH));
        $this->assertSame($exitCode, $formatter->formatErrors($this->getAnalysisResult($numFileErrors, $numGenericErrors), $this->getOutput()), \sprintf('%s: response code do not match', $message));
        $this->assertSame(\trim(\TenantCloud\BetterReflection\Relocated\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => $expected]], \TenantCloud\BetterReflection\Relocated\Nette\Neon\Neon::BLOCK)), \trim($this->getOutputContent()), \sprintf('%s: output do not match', $message));
    }
    public function testFormatErrorMessagesRegexEscape() : void
    {
        $formatter = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\BaselineNeonErrorFormatter(new \TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper(self::DIRECTORY_PATH));
        $result = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult([new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('Escape Regex with file # ~ \' ()', 'Testfile')], ['Escape Regex without file # ~ <> \' ()'], [], [], \false, null, \true);
        $formatter->formatErrors($result, $this->getOutput());
        self::assertSame(\trim(\TenantCloud\BetterReflection\Relocated\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => [['message' => "#^Escape Regex with file \\# ~ ' \\(\\)\$#", 'count' => 1, 'path' => 'Testfile']]]], \TenantCloud\BetterReflection\Relocated\Nette\Neon\Neon::BLOCK)), \trim($this->getOutputContent()));
    }
    public function testEscapeDiNeon() : void
    {
        $formatter = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\ErrorFormatter\BaselineNeonErrorFormatter(new \TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper(self::DIRECTORY_PATH));
        $result = new \TenantCloud\BetterReflection\Relocated\PHPStan\Command\AnalysisResult([new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('Test %value%', 'Testfile')], [], [], [], \false, null, \true);
        $formatter->formatErrors($result, $this->getOutput());
        self::assertSame(\trim(\TenantCloud\BetterReflection\Relocated\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => [['message' => '#^Test %%value%%$#', 'count' => 1, 'path' => 'Testfile']]]], \TenantCloud\BetterReflection\Relocated\Nette\Neon\Neon::BLOCK)), \trim($this->getOutputContent()));
    }
}
