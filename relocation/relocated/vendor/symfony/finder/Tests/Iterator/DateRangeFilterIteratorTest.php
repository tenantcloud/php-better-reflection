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

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Comparator\DateComparator;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\DateRangeFilterIterator;
class DateRangeFilterIteratorTest extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\RealIteratorTestCase
{
    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($size, $expected)
    {
        $files = self::$files;
        $files[] = self::toAbsolute('doesnotexist');
        $inner = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\Iterator($files);
        $iterator = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\DateRangeFilterIterator($inner, $size);
        $this->assertIterator($expected, $iterator);
    }
    public function getAcceptData()
    {
        $since20YearsAgo = ['.git', 'test.py', 'foo', 'foo/bar.tmp', 'test.php', 'toto', 'toto/.git', '.bar', '.foo', '.foo/.bar', 'foo bar', '.foo/bar', 'qux', 'qux/baz_100_1.py', 'qux/baz_1_2.py', 'qux_0_1.php', 'qux_1000_1.php', 'qux_1002_0.php', 'qux_10_2.php', 'qux_12_0.php', 'qux_2_0.php'];
        $since2MonthsAgo = ['.git', 'test.py', 'foo', 'toto', 'toto/.git', '.bar', '.foo', '.foo/.bar', 'foo bar', '.foo/bar', 'qux', 'qux/baz_100_1.py', 'qux/baz_1_2.py', 'qux_0_1.php', 'qux_1000_1.php', 'qux_1002_0.php', 'qux_10_2.php', 'qux_12_0.php', 'qux_2_0.php'];
        $untilLastMonth = ['foo/bar.tmp', 'test.php'];
        return [[[new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Comparator\DateComparator('since 20 years ago')], $this->toAbsolute($since20YearsAgo)], [[new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Comparator\DateComparator('since 2 months ago')], $this->toAbsolute($since2MonthsAgo)], [[new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Comparator\DateComparator('until last month')], $this->toAbsolute($untilLastMonth)]];
    }
}
