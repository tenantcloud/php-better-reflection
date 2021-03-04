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

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\LazyIterator;
class LazyIteratorTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testLazy()
    {
        new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\LazyIterator(function () {
            $this->markTestFailed('lazyIterator should not be called');
        });
        $this->expectNotToPerformAssertions();
    }
    public function testDelegate()
    {
        $iterator = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\LazyIterator(function () {
            return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\Iterator(['foo', 'bar']);
        });
        $this->assertCount(2, $iterator);
    }
    public function testInnerDestructedAtTheEnd()
    {
        $count = 0;
        $iterator = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\LazyIterator(function () use(&$count) {
            ++$count;
            return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\Iterator(['foo', 'bar']);
        });
        foreach ($iterator as $x) {
        }
        $this->assertSame(1, $count);
        foreach ($iterator as $x) {
        }
        $this->assertSame(2, $count);
    }
}
