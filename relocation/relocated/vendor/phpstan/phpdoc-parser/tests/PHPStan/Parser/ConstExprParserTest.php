<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser;

use Iterator;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer;
class ConstExprParserTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /** @var Lexer */
    private $lexer;
    /** @var ConstExprParser */
    private $constExprParser;
    protected function setUp() : void
    {
        parent::setUp();
        $this->lexer = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer();
        $this->constExprParser = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\ConstExprParser();
    }
    /**
     * @dataProvider provideTrueNodeParseData
     * @dataProvider provideFalseNodeParseData
     * @dataProvider provideNullNodeParseData
     * @dataProvider provideIntegerNodeParseData
     * @dataProvider provideFloatNodeParseData
     * @dataProvider provideStringNodeParseData
     * @dataProvider provideArrayNodeParseData
     * @dataProvider provideFetchNodeParseData
     * @param string        $input
     * @param ConstExprNode $expectedExpr
     * @param int           $nextTokenType
     */
    public function testParse(string $input, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $expectedExpr, int $nextTokenType = \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END) : void
    {
        $tokens = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TokenIterator($this->lexer->tokenize($input));
        $exprNode = $this->constExprParser->parse($tokens);
        $this->assertSame((string) $expectedExpr, (string) $exprNode);
        $this->assertEquals($expectedExpr, $exprNode);
        $this->assertSame($nextTokenType, $tokens->currentTokenType());
    }
    public function provideTrueNodeParseData() : \Iterator
    {
        (yield ['true', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode()]);
        (yield ['TRUE', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode()]);
        (yield ['tRUe', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode()]);
    }
    public function provideFalseNodeParseData() : \Iterator
    {
        (yield ['false', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode()]);
        (yield ['FALSE', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode()]);
        (yield ['fALse', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode()]);
    }
    public function provideNullNodeParseData() : \Iterator
    {
        (yield ['null', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode()]);
        (yield ['NULL', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode()]);
        (yield ['nULl', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode()]);
    }
    public function provideIntegerNodeParseData() : \Iterator
    {
        (yield ['123', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('123')]);
        (yield ['0b0110101', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('0b0110101')]);
        (yield ['0o777', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('0o777')]);
        (yield ['0x7Fb4', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('0x7Fb4')]);
        (yield ['-0O777', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('-0O777')]);
        (yield ['-0X7Fb4', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('-0X7Fb4')]);
    }
    public function provideFloatNodeParseData() : \Iterator
    {
        (yield ['123.4', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode('123.4')]);
        (yield ['.123', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode('.123')]);
        (yield ['123.', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode('123.')]);
        (yield ['123e4', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode('123e4')]);
        (yield ['123E4', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode('123E4')]);
        (yield ['12.3e4', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode('12.3e4')]);
        (yield ['-123', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('-123')]);
        (yield ['-123.4', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode('-123.4')]);
        (yield ['-.123', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode('-.123')]);
        (yield ['-123.', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode('-123.')]);
        (yield ['-123e-4', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode('-123e-4')]);
        (yield ['-12.3e-4', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode('-12.3e-4')]);
    }
    public function provideStringNodeParseData() : \Iterator
    {
        (yield ['"foo"', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode('"foo"')]);
        (yield ['"Foo \\n\\"\\r Bar"', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode('"Foo \\n\\"\\r Bar"')]);
        (yield ['\'bar\'', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode('\'bar\'')]);
        (yield ['\'Foo \\\' Bar\'', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode('\'Foo \\\' Bar\'')]);
    }
    public function provideArrayNodeParseData() : \Iterator
    {
        (yield ['[]', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode([])]);
        (yield ['[123]', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode([new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(null, new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('123'))])]);
        (yield ['[1, 2, 3]', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode([new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(null, new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('1')), new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(null, new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('2')), new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(null, new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('3'))])]);
        (yield ['[1, 2, 3, ]', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode([new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(null, new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('1')), new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(null, new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('2')), new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(null, new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('3'))])]);
        (yield ['[1 => 2]', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode([new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('1'), new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('2'))])]);
        (yield ['[1 => 2, 3]', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode([new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('1'), new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('2')), new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(null, new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('3'))])]);
        (yield ['[1, [2, 3]]', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode([new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(null, new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('1')), new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(null, new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode([new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(null, new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('2')), new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode(null, new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode('3'))]))])]);
    }
    public function provideFetchNodeParseData() : \Iterator
    {
        (yield ['GLOBAL_CONSTANT', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode('', 'GLOBAL_CONSTANT')]);
        (yield ['TenantCloud\\BetterReflection\\Relocated\\Foo\\Bar\\GLOBAL_CONSTANT', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode('', 'TenantCloud\\BetterReflection\\Relocated\\Foo\\Bar\\GLOBAL_CONSTANT')]);
        (yield ['Foo\\Bar::CLASS_CONSTANT', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode('TenantCloud\\BetterReflection\\Relocated\\Foo\\Bar', 'CLASS_CONSTANT')]);
        (yield ['self::CLASS_CONSTANT', new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode('self', 'CLASS_CONSTANT')]);
    }
}
