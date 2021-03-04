<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Whitespace;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<FileWhitespaceRule>
 */
class FileWhitespaceRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Whitespace\FileWhitespaceRule();
    }
    public function testBom() : void
    {
        $this->analyse([__DIR__ . '/data/bom.php'], [['File begins with UTF-8 BOM character. This may cause problems when running the code in the web browser.', 1]]);
    }
    public function testCorrectFile() : void
    {
        $this->analyse([__DIR__ . '/data/correct.php'], []);
    }
    public function testTrailingWhitespaceWithoutNamespace() : void
    {
        $this->analyse([__DIR__ . '/data/trailing.php'], [['File ends with a trailing whitespace. This may cause problems when running the code in the web browser. Remove the closing ?> mark or remove the whitespace.', 6]]);
    }
    public function testTrailingWhitespace() : void
    {
        $this->analyse([__DIR__ . '/data/trailing-namespace.php'], [['File ends with a trailing whitespace. This may cause problems when running the code in the web browser. Remove the closing ?> mark or remove the whitespace.', 8]]);
    }
    public function testHtmlAfterClose() : void
    {
        $this->analyse([__DIR__ . '/data/html-after-close.php'], []);
    }
}
