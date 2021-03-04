<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Input;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument;
class InputArgumentTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testConstructor()
    {
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo');
        $this->assertEquals('foo', $argument->getName(), '__construct() takes a name as its first argument');
    }
    public function testModes()
    {
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo');
        $this->assertFalse($argument->isRequired(), '__construct() gives a "InputArgument::OPTIONAL" mode by default');
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', null);
        $this->assertFalse($argument->isRequired(), '__construct() can take "InputArgument::OPTIONAL" as its mode');
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::OPTIONAL);
        $this->assertFalse($argument->isRequired(), '__construct() can take "InputArgument::OPTIONAL" as its mode');
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::REQUIRED);
        $this->assertTrue($argument->isRequired(), '__construct() can take "InputArgument::REQUIRED" as its mode');
    }
    public function testInvalidModes()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument mode "-1" is not valid.');
        new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', '-1');
    }
    public function testIsArray()
    {
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::IS_ARRAY);
        $this->assertTrue($argument->isArray(), '->isArray() returns true if the argument can be an array');
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::OPTIONAL | \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::IS_ARRAY);
        $this->assertTrue($argument->isArray(), '->isArray() returns true if the argument can be an array');
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::OPTIONAL);
        $this->assertFalse($argument->isArray(), '->isArray() returns false if the argument can not be an array');
    }
    public function testGetDescription()
    {
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', null, 'Some description');
        $this->assertEquals('Some description', $argument->getDescription(), '->getDescription() return the message description');
    }
    public function testGetDefault()
    {
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::OPTIONAL, '', 'default');
        $this->assertEquals('default', $argument->getDefault(), '->getDefault() return the default value');
    }
    public function testSetDefault()
    {
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::OPTIONAL, '', 'default');
        $argument->setDefault(null);
        $this->assertNull($argument->getDefault(), '->setDefault() can reset the default value by passing null');
        $argument->setDefault('another');
        $this->assertEquals('another', $argument->getDefault(), '->setDefault() changes the default value');
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::OPTIONAL | \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::IS_ARRAY);
        $argument->setDefault([1, 2]);
        $this->assertEquals([1, 2], $argument->getDefault(), '->setDefault() changes the default value');
    }
    public function testSetDefaultWithRequiredArgument()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Cannot set a default value except for InputArgument::OPTIONAL mode.');
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::REQUIRED);
        $argument->setDefault('default');
    }
    public function testSetDefaultWithArrayArgument()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('A default value for an array argument must be an array.');
        $argument = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::IS_ARRAY);
        $argument->setDefault('default');
    }
}
