<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Formatter;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyle;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyleStack;
class OutputFormatterStyleStackTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testPush()
    {
        $stack = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyleStack();
        $stack->push($s1 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyle('white', 'black'));
        $stack->push($s2 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyle('yellow', 'blue'));
        $this->assertEquals($s2, $stack->getCurrent());
        $stack->push($s3 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyle('green', 'red'));
        $this->assertEquals($s3, $stack->getCurrent());
    }
    public function testPop()
    {
        $stack = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyleStack();
        $stack->push($s1 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyle('white', 'black'));
        $stack->push($s2 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyle('yellow', 'blue'));
        $this->assertEquals($s2, $stack->pop());
        $this->assertEquals($s1, $stack->pop());
    }
    public function testPopEmpty()
    {
        $stack = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyleStack();
        $style = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyle();
        $this->assertEquals($style, $stack->pop());
    }
    public function testPopNotLast()
    {
        $stack = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyleStack();
        $stack->push($s1 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyle('white', 'black'));
        $stack->push($s2 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyle('yellow', 'blue'));
        $stack->push($s3 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyle('green', 'red'));
        $this->assertEquals($s2, $stack->pop($s2));
        $this->assertEquals($s1, $stack->pop());
    }
    public function testInvalidPop()
    {
        $this->expectException(\InvalidArgumentException::class);
        $stack = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyleStack();
        $stack->push(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyle('white', 'black'));
        $stack->pop(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatterStyle('yellow', 'blue'));
    }
}
