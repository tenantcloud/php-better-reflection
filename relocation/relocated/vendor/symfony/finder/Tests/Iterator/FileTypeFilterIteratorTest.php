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

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\FileTypeFilterIterator;
class FileTypeFilterIteratorTest extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\RealIteratorTestCase
{
    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($mode, $expected)
    {
        $inner = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\InnerTypeIterator(self::$files);
        $iterator = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\FileTypeFilterIterator($inner, $mode);
        $this->assertIterator($expected, $iterator);
    }
    public function getAcceptData()
    {
        $onlyFiles = ['test.py', 'foo/bar.tmp', 'test.php', '.bar', '.foo/.bar', '.foo/bar', 'foo bar', 'qux/baz_100_1.py', 'qux/baz_1_2.py', 'qux_0_1.php', 'qux_1000_1.php', 'qux_1002_0.php', 'qux_10_2.php', 'qux_12_0.php', 'qux_2_0.php'];
        $onlyDirectories = ['.git', 'foo', 'qux', 'toto', 'toto/.git', '.foo'];
        return [[\TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\FileTypeFilterIterator::ONLY_FILES, $this->toAbsolute($onlyFiles)], [\TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\FileTypeFilterIterator::ONLY_DIRECTORIES, $this->toAbsolute($onlyDirectories)]];
    }
}
class InnerTypeIterator extends \ArrayIterator
{
    public function current()
    {
        return new \SplFileInfo(parent::current());
    }
    public function isFile()
    {
        return $this->current()->isFile();
    }
    public function isDir()
    {
        return $this->current()->isDir();
    }
}