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
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\ArgvInput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput;
class StringInputTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getTokenizeData
     */
    public function testTokenize($input, $tokens, $message)
    {
        $input = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput($input);
        $r = new \ReflectionClass(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\ArgvInput::class);
        $p = $r->getProperty('tokens');
        $p->setAccessible(\true);
        $this->assertEquals($tokens, $p->getValue($input), $message);
    }
    public function testInputOptionWithGivenString()
    {
        $definition = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputDefinition([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption('foo', null, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED)]);
        // call to bind
        $input = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput('--foo=bar');
        $input->bind($definition);
        $this->assertEquals('bar', $input->getOption('foo'));
    }
    public function getTokenizeData()
    {
        return [['', [], '->tokenize() parses an empty string'], ['foo', ['foo'], '->tokenize() parses arguments'], ['  foo  bar  ', ['foo', 'bar'], '->tokenize() ignores whitespaces between arguments'], ['"quoted"', ['quoted'], '->tokenize() parses quoted arguments'], ["'quoted'", ['quoted'], '->tokenize() parses quoted arguments'], ["'a\rb\nc\td'", ["a\rb\nc\td"], '->tokenize() parses whitespace chars in strings'], ["'a'\r'b'\n'c'\t'd'", ['a', 'b', 'c', 'd'], '->tokenize() parses whitespace chars between args as spaces'], ['\\"quoted\\"', ['"quoted"'], '->tokenize() parses escaped-quoted arguments'], ["\\'quoted\\'", ['\'quoted\''], '->tokenize() parses escaped-quoted arguments'], ['-a', ['-a'], '->tokenize() parses short options'], ['-azc', ['-azc'], '->tokenize() parses aggregated short options'], ['-awithavalue', ['-awithavalue'], '->tokenize() parses short options with a value'], ['-a"foo bar"', ['-afoo bar'], '->tokenize() parses short options with a value'], ['-a"foo bar""foo bar"', ['-afoo barfoo bar'], '->tokenize() parses short options with a value'], ['-a\'foo bar\'', ['-afoo bar'], '->tokenize() parses short options with a value'], ['-a\'foo bar\'\'foo bar\'', ['-afoo barfoo bar'], '->tokenize() parses short options with a value'], ['-a\'foo bar\'"foo bar"', ['-afoo barfoo bar'], '->tokenize() parses short options with a value'], ['--long-option', ['--long-option'], '->tokenize() parses long options'], ['--long-option=foo', ['--long-option=foo'], '->tokenize() parses long options with a value'], ['--long-option="foo bar"', ['--long-option=foo bar'], '->tokenize() parses long options with a value'], ['--long-option="foo bar""another"', ['--long-option=foo baranother'], '->tokenize() parses long options with a value'], ['--long-option=\'foo bar\'', ['--long-option=foo bar'], '->tokenize() parses long options with a value'], ["--long-option='foo bar''another'", ['--long-option=foo baranother'], '->tokenize() parses long options with a value'], ["--long-option='foo bar'\"another\"", ['--long-option=foo baranother'], '->tokenize() parses long options with a value'], ['foo -a -ffoo --long bar', ['foo', '-a', '-ffoo', '--long', 'bar'], '->tokenize() parses when several arguments and options']];
    }
    public function testToString()
    {
        $input = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput('-f foo');
        $this->assertEquals('-f foo', (string) $input);
        $input = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput('-f --bar=foo "a b c d"');
        $this->assertEquals('-f --bar=foo ' . \escapeshellarg('a b c d'), (string) $input);
        $input = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StringInput('-f --bar=foo \'a b c d\' ' . "'A\nB\\'C'");
        $this->assertEquals('-f --bar=foo ' . \escapeshellarg('a b c d') . ' ' . \escapeshellarg("A\nB'C"), (string) $input);
    }
}
