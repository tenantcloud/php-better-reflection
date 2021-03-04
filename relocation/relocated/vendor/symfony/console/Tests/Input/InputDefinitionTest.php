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
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption;
class InputDefinitionTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    protected static $fixtures;
    protected $multi;
    protected $foo;
    protected $bar;
    protected $foo1;
    protected $foo2;
    public static function setUpBeforeClass() : void
    {
        self::$fixtures = __DIR__ . '/../Fixtures/';
    }
    public function testConstructorArguments()
    {
        $this->initializeArguments();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $this->assertEquals([], $definition->getArguments(), '__construct() creates a new InputDefinition object');
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([$this->foo, $this->bar]);
        $this->assertEquals(['foo' => $this->foo, 'bar' => $this->bar], $definition->getArguments(), '__construct() takes an array of InputArgument objects as its first argument');
    }
    public function testConstructorOptions()
    {
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $this->assertEquals([], $definition->getOptions(), '__construct() creates a new InputDefinition object');
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([$this->foo, $this->bar]);
        $this->assertEquals(['foo' => $this->foo, 'bar' => $this->bar], $definition->getOptions(), '__construct() takes an array of InputOption objects as its first argument');
    }
    public function testSetArguments()
    {
        $this->initializeArguments();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->setArguments([$this->foo]);
        $this->assertEquals(['foo' => $this->foo], $definition->getArguments(), '->setArguments() sets the array of InputArgument objects');
        $definition->setArguments([$this->bar]);
        $this->assertEquals(['bar' => $this->bar], $definition->getArguments(), '->setArguments() clears all InputArgument objects');
    }
    public function testAddArguments()
    {
        $this->initializeArguments();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->addArguments([$this->foo]);
        $this->assertEquals(['foo' => $this->foo], $definition->getArguments(), '->addArguments() adds an array of InputArgument objects');
        $definition->addArguments([$this->bar]);
        $this->assertEquals(['foo' => $this->foo, 'bar' => $this->bar], $definition->getArguments(), '->addArguments() does not clear existing InputArgument objects');
    }
    public function testAddArgument()
    {
        $this->initializeArguments();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->addArgument($this->foo);
        $this->assertEquals(['foo' => $this->foo], $definition->getArguments(), '->addArgument() adds a InputArgument object');
        $definition->addArgument($this->bar);
        $this->assertEquals(['foo' => $this->foo, 'bar' => $this->bar], $definition->getArguments(), '->addArgument() adds a InputArgument object');
    }
    public function testArgumentsMustHaveDifferentNames()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('An argument with name "foo" already exists.');
        $this->initializeArguments();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->addArgument($this->foo);
        $definition->addArgument($this->foo1);
    }
    public function testArrayArgumentHasToBeLast()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Cannot add an argument after an array argument.');
        $this->initializeArguments();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->addArgument(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('fooarray', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::IS_ARRAY));
        $definition->addArgument(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('anotherbar'));
    }
    public function testRequiredArgumentCannotFollowAnOptionalOne()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Cannot add a required argument after an optional one.');
        $this->initializeArguments();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->addArgument($this->foo);
        $definition->addArgument($this->foo2);
    }
    public function testGetArgument()
    {
        $this->initializeArguments();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->addArguments([$this->foo]);
        $this->assertEquals($this->foo, $definition->getArgument('foo'), '->getArgument() returns a InputArgument by its name');
    }
    public function testGetInvalidArgument()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The "bar" argument does not exist.');
        $this->initializeArguments();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->addArguments([$this->foo]);
        $definition->getArgument('bar');
    }
    public function testHasArgument()
    {
        $this->initializeArguments();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->addArguments([$this->foo]);
        $this->assertTrue($definition->hasArgument('foo'), '->hasArgument() returns true if a InputArgument exists for the given name');
        $this->assertFalse($definition->hasArgument('bar'), '->hasArgument() returns false if a InputArgument exists for the given name');
    }
    public function testGetArgumentRequiredCount()
    {
        $this->initializeArguments();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->addArgument($this->foo2);
        $this->assertEquals(1, $definition->getArgumentRequiredCount(), '->getArgumentRequiredCount() returns the number of required arguments');
        $definition->addArgument($this->foo);
        $this->assertEquals(1, $definition->getArgumentRequiredCount(), '->getArgumentRequiredCount() returns the number of required arguments');
    }
    public function testGetArgumentCount()
    {
        $this->initializeArguments();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->addArgument($this->foo2);
        $this->assertEquals(1, $definition->getArgumentCount(), '->getArgumentCount() returns the number of arguments');
        $definition->addArgument($this->foo);
        $this->assertEquals(2, $definition->getArgumentCount(), '->getArgumentCount() returns the number of arguments');
    }
    public function testGetArgumentDefaults()
    {
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo1', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::OPTIONAL), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo2', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::OPTIONAL, '', 'default'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo3', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::OPTIONAL | \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::IS_ARRAY)]);
        $this->assertEquals(['foo1' => null, 'foo2' => 'default', 'foo3' => []], $definition->getArgumentDefaults(), '->getArgumentDefaults() return the default values for each argument');
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo4', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::OPTIONAL | \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, '', [1, 2])]);
        $this->assertEquals(['foo4' => [1, 2]], $definition->getArgumentDefaults(), '->getArgumentDefaults() return the default values for each argument');
    }
    public function testSetOptions()
    {
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([$this->foo]);
        $this->assertEquals(['foo' => $this->foo], $definition->getOptions(), '->setOptions() sets the array of InputOption objects');
        $definition->setOptions([$this->bar]);
        $this->assertEquals(['bar' => $this->bar], $definition->getOptions(), '->setOptions() clears all InputOption objects');
    }
    public function testSetOptionsClearsOptions()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The "-f" option does not exist.');
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([$this->foo]);
        $definition->setOptions([$this->bar]);
        $definition->getOptionForShortcut('f');
    }
    public function testAddOptions()
    {
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([$this->foo]);
        $this->assertEquals(['foo' => $this->foo], $definition->getOptions(), '->addOptions() adds an array of InputOption objects');
        $definition->addOptions([$this->bar]);
        $this->assertEquals(['foo' => $this->foo, 'bar' => $this->bar], $definition->getOptions(), '->addOptions() does not clear existing InputOption objects');
    }
    public function testAddOption()
    {
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->addOption($this->foo);
        $this->assertEquals(['foo' => $this->foo], $definition->getOptions(), '->addOption() adds a InputOption object');
        $definition->addOption($this->bar);
        $this->assertEquals(['foo' => $this->foo, 'bar' => $this->bar], $definition->getOptions(), '->addOption() adds a InputOption object');
    }
    public function testAddDuplicateOption()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('An option named "foo" already exists.');
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->addOption($this->foo);
        $definition->addOption($this->foo2);
    }
    public function testAddDuplicateShortcutOption()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('An option with shortcut "f" already exists.');
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition();
        $definition->addOption($this->foo);
        $definition->addOption($this->foo1);
    }
    public function testGetOption()
    {
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([$this->foo]);
        $this->assertEquals($this->foo, $definition->getOption('foo'), '->getOption() returns a InputOption by its name');
    }
    public function testGetInvalidOption()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The "--bar" option does not exist.');
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([$this->foo]);
        $definition->getOption('bar');
    }
    public function testHasOption()
    {
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([$this->foo]);
        $this->assertTrue($definition->hasOption('foo'), '->hasOption() returns true if a InputOption exists for the given name');
        $this->assertFalse($definition->hasOption('bar'), '->hasOption() returns false if a InputOption exists for the given name');
    }
    public function testHasShortcut()
    {
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([$this->foo]);
        $this->assertTrue($definition->hasShortcut('f'), '->hasShortcut() returns true if a InputOption exists for the given shortcut');
        $this->assertFalse($definition->hasShortcut('b'), '->hasShortcut() returns false if a InputOption exists for the given shortcut');
    }
    public function testGetOptionForShortcut()
    {
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([$this->foo]);
        $this->assertEquals($this->foo, $definition->getOptionForShortcut('f'), '->getOptionForShortcut() returns a InputOption by its shortcut');
    }
    public function testGetOptionForMultiShortcut()
    {
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([$this->multi]);
        $this->assertEquals($this->multi, $definition->getOptionForShortcut('m'), '->getOptionForShortcut() returns a InputOption by its shortcut');
        $this->assertEquals($this->multi, $definition->getOptionForShortcut('mmm'), '->getOptionForShortcut() returns a InputOption by its shortcut');
    }
    public function testGetOptionForInvalidShortcut()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The "-l" option does not exist.');
        $this->initializeOptions();
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([$this->foo]);
        $definition->getOptionForShortcut('l');
    }
    public function testGetOptionDefaults()
    {
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo1', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_NONE), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo2', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo3', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, '', 'default'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo4', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo5', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL, '', 'default'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo6', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL | \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_IS_ARRAY), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo7', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL | \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_IS_ARRAY, '', [1, 2])]);
        $defaults = ['foo1' => \false, 'foo2' => null, 'foo3' => 'default', 'foo4' => null, 'foo5' => 'default', 'foo6' => [], 'foo7' => [1, 2]];
        $this->assertSame($defaults, $definition->getOptionDefaults(), '->getOptionDefaults() returns the default values for all options');
    }
    /**
     * @dataProvider getGetSynopsisData
     */
    public function testGetSynopsis(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition $definition, $expectedSynopsis, $message = null)
    {
        $this->assertEquals($expectedSynopsis, $definition->getSynopsis(), $message ? '->getSynopsis() ' . $message : '');
    }
    public function getGetSynopsisData()
    {
        return [[new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo')]), '[--foo]', 'puts optional options in square brackets'], [new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo', 'f')]), '[-f|--foo]', 'separates shortcut with a pipe'], [new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo', 'f', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED)]), '[-f|--foo FOO]', 'uses shortcut as value placeholder'], [new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo', 'f', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL)]), '[-f|--foo [FOO]]', 'puts optional values in square brackets'], [new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::REQUIRED)]), '<foo>', 'puts arguments in angle brackets'], [new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo')]), '[<foo>]', 'puts optional arguments in square brackets'], [new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('bar')]), '[<foo> [<bar>]]', 'chains optional arguments inside brackets'], [new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::IS_ARRAY)]), '[<foo>...]', 'uses an ellipsis for array arguments'], [new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::REQUIRED | \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::IS_ARRAY)]), '<foo>...', 'uses an ellipsis for required array arguments'], [new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::REQUIRED)]), '[--foo] [--] <foo>', 'puts [--] between options and arguments']];
    }
    public function testGetShortSynopsis()
    {
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('bar'), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('cat')]);
        $this->assertEquals('[options] [--] [<cat>]', $definition->getSynopsis(\true), '->getSynopsis(true) groups options in [options]');
    }
    protected function initializeArguments()
    {
        $this->foo = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo');
        $this->bar = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('bar');
        $this->foo1 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo');
        $this->foo2 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument('foo2', \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputArgument::REQUIRED);
    }
    protected function initializeOptions()
    {
        $this->foo = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo', 'f');
        $this->bar = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('bar', 'b');
        $this->foo1 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('fooBis', 'f');
        $this->foo2 = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo', 'p');
        $this->multi = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('multi', 'm|mm|mmm');
    }
}
