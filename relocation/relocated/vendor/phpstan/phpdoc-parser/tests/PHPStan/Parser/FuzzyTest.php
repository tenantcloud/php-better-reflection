<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser;

use Iterator;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Process\Process;
class FuzzyTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /** @var Lexer */
    private $lexer;
    /** @var TypeParser */
    private $typeParser;
    /** @var ConstExprParser */
    private $constExprParser;
    protected function setUp() : void
    {
        parent::setUp();
        $this->lexer = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer();
        $this->typeParser = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TypeParser(new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\ConstExprParser());
        $this->constExprParser = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\ConstExprParser();
    }
    /**
     * @dataProvider provideTypeParserData
     * @param string $input
     */
    public function testTypeParser(string $input) : void
    {
        $tokens = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TokenIterator($this->lexer->tokenize($input));
        $this->typeParser->parse($tokens);
        $this->assertSame(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END, $tokens->currentTokenType(), \sprintf('Failed to parse input %s', $input));
    }
    public function provideTypeParserData() : \Iterator
    {
        return $this->provideFuzzyInputsData('Type');
    }
    /**
     * @dataProvider provideConstExprParserData
     * @param string $input
     */
    public function testConstExprParser(string $input) : void
    {
        $tokens = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TokenIterator($this->lexer->tokenize($input));
        $this->constExprParser->parse($tokens);
        $this->assertSame(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END, $tokens->currentTokenType(), \sprintf('Failed to parse input %s', $input));
    }
    public function provideConstExprParserData() : \Iterator
    {
        return $this->provideFuzzyInputsData('ConstantExpr');
    }
    private function provideFuzzyInputsData(string $startSymbol) : \Iterator
    {
        $inputsDirectory = \sprintf('%s/fuzzy/%s', __DIR__ . '/../../../temp', $startSymbol);
        if (\is_dir($inputsDirectory)) {
            foreach (\glob(\sprintf('%s/*.tst', $inputsDirectory)) as $file) {
                \unlink($file);
            }
        } else {
            \mkdir($inputsDirectory, 0777, \true);
        }
        $process = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Process\Process([__DIR__ . '/../../../tools/abnfgen/abnfgen', '-lx', '-n', '1000', '-d', $inputsDirectory, '-s', $startSymbol, __DIR__ . '/../../../doc/grammars/type.abnf']);
        $process->mustRun();
        foreach (\glob(\sprintf('%s/*.tst', $inputsDirectory)) as $file) {
            $input = \file_get_contents($file);
            (yield [$input]);
        }
    }
}
