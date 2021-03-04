<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\ExcludeDirectoryFilterIterator;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;
class ExcludeDirectoryFilterIteratorTest extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\RealIteratorTestCase
{
    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($directories, $expected)
    {
        $inner = new \RecursiveIteratorIterator(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator($this->toAbsolute(), \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST);
        $iterator = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\ExcludeDirectoryFilterIterator($inner, $directories);
        $this->assertIterator($expected, $iterator);
    }
    public function getAcceptData()
    {
        $foo = ['.gitignore', '.bar', '.foo', '.foo/.bar', '.foo/bar', '.git', 'test.py', 'test.php', 'toto', 'toto/.git', 'foo bar', 'qux', 'qux/baz_100_1.py', 'qux/baz_1_2.py', 'qux_0_1.php', 'qux_1000_1.php', 'qux_1002_0.php', 'qux_10_2.php', 'qux_12_0.php', 'qux_2_0.php'];
        $fo = ['.gitignore', '.bar', '.foo', '.foo/.bar', '.foo/bar', '.git', 'test.py', 'foo', 'foo/bar.tmp', 'test.php', 'toto', 'toto/.git', 'foo bar', 'qux', 'qux/baz_100_1.py', 'qux/baz_1_2.py', 'qux_0_1.php', 'qux_1000_1.php', 'qux_1002_0.php', 'qux_10_2.php', 'qux_12_0.php', 'qux_2_0.php'];
        $toto = ['.gitignore', '.bar', '.foo', '.foo/.bar', '.foo/bar', '.git', 'test.py', 'foo', 'foo/bar.tmp', 'test.php', 'foo bar', 'qux', 'qux/baz_100_1.py', 'qux/baz_1_2.py', 'qux_0_1.php', 'qux_1000_1.php', 'qux_1002_0.php', 'qux_10_2.php', 'qux_12_0.php', 'qux_2_0.php'];
        return [[['foo'], $this->toAbsolute($foo)], [['fo'], $this->toAbsolute($fo)], [['toto/'], $this->toAbsolute($toto)]];
    }
}
