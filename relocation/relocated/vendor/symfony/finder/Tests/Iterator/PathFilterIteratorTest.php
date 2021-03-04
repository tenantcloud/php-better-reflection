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

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\PathFilterIterator;
class PathFilterIteratorTest extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\IteratorTestCase
{
    /**
     * @dataProvider getTestFilterData
     */
    public function testFilter(\Iterator $inner, array $matchPatterns, array $noMatchPatterns, array $resultArray)
    {
        $iterator = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\PathFilterIterator($inner, $matchPatterns, $noMatchPatterns);
        $this->assertIterator($resultArray, $iterator);
    }
    public function getTestFilterData()
    {
        $inner = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\MockFileListIterator();
        //PATH:   A/B/C/abc.dat
        $inner[] = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\MockSplFileInfo(['name' => 'abc.dat', 'relativePathname' => 'A' . \DIRECTORY_SEPARATOR . 'B' . \DIRECTORY_SEPARATOR . 'C' . \DIRECTORY_SEPARATOR . 'abc.dat']);
        //PATH:   A/B/ab.dat
        $inner[] = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\MockSplFileInfo(['name' => 'ab.dat', 'relativePathname' => 'A' . \DIRECTORY_SEPARATOR . 'B' . \DIRECTORY_SEPARATOR . 'ab.dat']);
        //PATH:   A/a.dat
        $inner[] = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\MockSplFileInfo(['name' => 'a.dat', 'relativePathname' => 'A' . \DIRECTORY_SEPARATOR . 'a.dat']);
        //PATH:   copy/A/B/C/abc.dat.copy
        $inner[] = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\MockSplFileInfo(['name' => 'abc.dat.copy', 'relativePathname' => 'copy' . \DIRECTORY_SEPARATOR . 'A' . \DIRECTORY_SEPARATOR . 'B' . \DIRECTORY_SEPARATOR . 'C' . \DIRECTORY_SEPARATOR . 'abc.dat']);
        //PATH:   copy/A/B/ab.dat.copy
        $inner[] = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\MockSplFileInfo(['name' => 'ab.dat.copy', 'relativePathname' => 'copy' . \DIRECTORY_SEPARATOR . 'A' . \DIRECTORY_SEPARATOR . 'B' . \DIRECTORY_SEPARATOR . 'ab.dat']);
        //PATH:   copy/A/a.dat.copy
        $inner[] = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\MockSplFileInfo(['name' => 'a.dat.copy', 'relativePathname' => 'copy' . \DIRECTORY_SEPARATOR . 'A' . \DIRECTORY_SEPARATOR . 'a.dat']);
        return [[$inner, ['/^A/'], [], ['abc.dat', 'ab.dat', 'a.dat']], [$inner, ['/^A\\/B/'], [], ['abc.dat', 'ab.dat']], [$inner, ['/^A\\/B\\/C/'], [], ['abc.dat']], [$inner, ['/A\\/B\\/C/'], [], ['abc.dat', 'abc.dat.copy']], [$inner, ['A'], [], ['abc.dat', 'ab.dat', 'a.dat', 'abc.dat.copy', 'ab.dat.copy', 'a.dat.copy']], [$inner, ['A/B'], [], ['abc.dat', 'ab.dat', 'abc.dat.copy', 'ab.dat.copy']], [$inner, ['A/B/C'], [], ['abc.dat', 'abc.dat.copy']], [$inner, ['copy/A'], [], ['abc.dat.copy', 'ab.dat.copy', 'a.dat.copy']], [$inner, ['copy/A/B'], [], ['abc.dat.copy', 'ab.dat.copy']], [$inner, ['copy/A/B/C'], [], ['abc.dat.copy']]];
    }
}
