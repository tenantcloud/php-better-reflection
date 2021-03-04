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

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator;
class SortableIteratorTest extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\RealIteratorTestCase
{
    public function testConstructor()
    {
        try {
            new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\Iterator([]), 'foobar');
            $this->fail('__construct() throws an \\InvalidArgumentException exception if the mode is not valid');
        } catch (\Exception $e) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $e, '__construct() throws an \\InvalidArgumentException exception if the mode is not valid');
        }
    }
    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($mode, $expected)
    {
        if (!\is_callable($mode)) {
            switch ($mode) {
                case \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator::SORT_BY_ACCESSED_TIME:
                    \touch(self::toAbsolute('.git'));
                    \sleep(1);
                    \touch(self::toAbsolute('.bar'), \time());
                    break;
                case \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator::SORT_BY_CHANGED_TIME:
                    \sleep(1);
                    \file_put_contents(self::toAbsolute('test.php'), 'foo');
                    \sleep(1);
                    \file_put_contents(self::toAbsolute('test.py'), 'foo');
                    break;
                case \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator::SORT_BY_MODIFIED_TIME:
                    \file_put_contents(self::toAbsolute('test.php'), 'foo');
                    \sleep(1);
                    \file_put_contents(self::toAbsolute('test.py'), 'foo');
                    break;
            }
        }
        $inner = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\Iterator(self::$files);
        $iterator = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator($inner, $mode);
        if (\TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator::SORT_BY_ACCESSED_TIME === $mode || \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator::SORT_BY_CHANGED_TIME === $mode || \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator::SORT_BY_MODIFIED_TIME === $mode) {
            if ('\\' === \DIRECTORY_SEPARATOR && \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator::SORT_BY_MODIFIED_TIME !== $mode) {
                $this->markTestSkipped('Sorting by atime or ctime is not supported on Windows');
            }
            $this->assertOrderedIteratorForGroups($expected, $iterator);
        } else {
            $this->assertOrderedIterator($expected, $iterator);
        }
    }
    public function getAcceptData()
    {
        $sortByName = ['.bar', '.foo', '.foo/.bar', '.foo/bar', '.git', 'foo', 'foo bar', 'foo/bar.tmp', 'qux', 'qux/baz_100_1.py', 'qux/baz_1_2.py', 'qux_0_1.php', 'qux_1000_1.php', 'qux_1002_0.php', 'qux_10_2.php', 'qux_12_0.php', 'qux_2_0.php', 'test.php', 'test.py', 'toto', 'toto/.git'];
        $sortByType = ['.foo', '.git', 'foo', 'qux', 'toto', 'toto/.git', '.bar', '.foo/.bar', '.foo/bar', 'foo bar', 'foo/bar.tmp', 'qux/baz_100_1.py', 'qux/baz_1_2.py', 'qux_0_1.php', 'qux_1000_1.php', 'qux_1002_0.php', 'qux_10_2.php', 'qux_12_0.php', 'qux_2_0.php', 'test.php', 'test.py'];
        $sortByAccessedTime = [
            // For these two files the access time was set to 2005-10-15
            ['foo/bar.tmp', 'test.php'],
            // These files were created more or less at the same time
            ['.git', '.foo', '.foo/.bar', '.foo/bar', 'test.py', 'foo', 'toto', 'toto/.git', 'foo bar', 'qux', 'qux/baz_100_1.py', 'qux/baz_1_2.py', 'qux_0_1.php', 'qux_1000_1.php', 'qux_1002_0.php', 'qux_10_2.php', 'qux_12_0.php', 'qux_2_0.php'],
            // This file was accessed after sleeping for 1 sec
            ['.bar'],
        ];
        $sortByChangedTime = [['.git', '.foo', '.foo/.bar', '.foo/bar', '.bar', 'foo', 'foo/bar.tmp', 'toto', 'toto/.git', 'foo bar', 'qux', 'qux/baz_100_1.py', 'qux/baz_1_2.py', 'qux_0_1.php', 'qux_1000_1.php', 'qux_1002_0.php', 'qux_10_2.php', 'qux_12_0.php', 'qux_2_0.php'], ['test.php'], ['test.py']];
        $sortByModifiedTime = [['.git', '.foo', '.foo/.bar', '.foo/bar', '.bar', 'foo', 'foo/bar.tmp', 'toto', 'toto/.git', 'foo bar', 'qux', 'qux/baz_100_1.py', 'qux/baz_1_2.py', 'qux_0_1.php', 'qux_1000_1.php', 'qux_1002_0.php', 'qux_10_2.php', 'qux_12_0.php', 'qux_2_0.php'], ['test.php'], ['test.py']];
        $sortByNameNatural = ['.bar', '.foo', '.foo/.bar', '.foo/bar', '.git', 'foo', 'foo/bar.tmp', 'foo bar', 'qux', 'qux/baz_1_2.py', 'qux/baz_100_1.py', 'qux_0_1.php', 'qux_2_0.php', 'qux_10_2.php', 'qux_12_0.php', 'qux_1000_1.php', 'qux_1002_0.php', 'test.php', 'test.py', 'toto', 'toto/.git'];
        $customComparison = ['.bar', '.foo', '.foo/.bar', '.foo/bar', '.git', 'foo', 'foo bar', 'foo/bar.tmp', 'qux', 'qux/baz_100_1.py', 'qux/baz_1_2.py', 'qux_0_1.php', 'qux_1000_1.php', 'qux_1002_0.php', 'qux_10_2.php', 'qux_12_0.php', 'qux_2_0.php', 'test.php', 'test.py', 'toto', 'toto/.git'];
        return [[\TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator::SORT_BY_NAME, $this->toAbsolute($sortByName)], [\TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator::SORT_BY_TYPE, $this->toAbsolute($sortByType)], [\TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator::SORT_BY_ACCESSED_TIME, $this->toAbsolute($sortByAccessedTime)], [\TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator::SORT_BY_CHANGED_TIME, $this->toAbsolute($sortByChangedTime)], [\TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator::SORT_BY_MODIFIED_TIME, $this->toAbsolute($sortByModifiedTime)], [\TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SortableIterator::SORT_BY_NAME_NATURAL, $this->toAbsolute($sortByNameNatural)], [function (\SplFileInfo $a, \SplFileInfo $b) {
            return \strcmp($a->getRealPath(), $b->getRealPath());
        }, $this->toAbsolute($customComparison)]];
    }
}
