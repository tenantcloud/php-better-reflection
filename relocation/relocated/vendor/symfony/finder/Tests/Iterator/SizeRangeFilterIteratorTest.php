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

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Comparator\NumberComparator;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SizeRangeFilterIterator;
class SizeRangeFilterIteratorTest extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\RealIteratorTestCase
{
    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($size, $expected)
    {
        $inner = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\InnerSizeIterator(self::$files);
        $iterator = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\SizeRangeFilterIterator($inner, $size);
        $this->assertIterator($expected, $iterator);
    }
    public function getAcceptData()
    {
        $lessThan1KGreaterThan05K = ['.foo', '.git', 'foo', 'qux', 'test.php', 'toto', 'toto/.git'];
        return [[[new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Comparator\NumberComparator('< 1K'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Comparator\NumberComparator('> 0.5K')], $this->toAbsolute($lessThan1KGreaterThan05K)]];
    }
}
class InnerSizeIterator extends \ArrayIterator
{
    public function current()
    {
        return new \SplFileInfo(parent::current());
    }
    public function getFilename()
    {
        return parent::current();
    }
    public function isFile()
    {
        return $this->current()->isFile();
    }
    public function getSize()
    {
        return $this->current()->getSize();
    }
}
