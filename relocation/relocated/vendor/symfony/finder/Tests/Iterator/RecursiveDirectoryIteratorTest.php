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

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;
class RecursiveDirectoryIteratorTest extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests\Iterator\IteratorTestCase
{
    /**
     * @group network
     */
    public function testRewindOnFtp()
    {
        try {
            $i = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator('ftp://speedtest.tele2.net/', \RecursiveDirectoryIterator::SKIP_DOTS);
        } catch (\UnexpectedValueException $e) {
            $this->markTestSkipped('Unsupported stream "ftp".');
        }
        $i->rewind();
        $this->assertTrue(\true);
    }
    /**
     * @group network
     */
    public function testSeekOnFtp()
    {
        try {
            $i = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator('ftp://speedtest.tele2.net/', \RecursiveDirectoryIterator::SKIP_DOTS);
        } catch (\UnexpectedValueException $e) {
            $this->markTestSkipped('Unsupported stream "ftp".');
        }
        $contains = ['ftp://speedtest.tele2.net' . \DIRECTORY_SEPARATOR . '1000GB.zip', 'ftp://speedtest.tele2.net' . \DIRECTORY_SEPARATOR . '100GB.zip'];
        $actual = [];
        $i->seek(0);
        $actual[] = $i->getPathname();
        $i->seek(1);
        $actual[] = $i->getPathname();
        $this->assertEquals($contains, $actual);
    }
}
