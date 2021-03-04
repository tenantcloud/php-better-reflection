<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Parser;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase;
class CachedParserTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    /**
     * @dataProvider dataParseFileClearCache
     * @param int $cachedNodesByStringCountMax
     * @param int $cachedNodesByStringCountExpected
     */
    public function testParseFileClearCache(int $cachedNodesByStringCountMax, int $cachedNodesByStringCountExpected) : void
    {
        $parser = new \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\CachedParser($this->getParserMock(), $cachedNodesByStringCountMax);
        $this->assertEquals($cachedNodesByStringCountMax, $parser->getCachedNodesByStringCountMax());
        // Add strings to cache
        for ($i = 0; $i <= $cachedNodesByStringCountMax; $i++) {
            $parser->parseString('string' . $i);
        }
        $this->assertEquals($cachedNodesByStringCountExpected, $parser->getCachedNodesByStringCount());
        $this->assertCount($cachedNodesByStringCountExpected, $parser->getCachedNodesByString());
    }
    public function dataParseFileClearCache() : \Generator
    {
        (yield 'even' => ['cachedNodesByStringCountMax' => 50, 'cachedNodesByStringCountExpected' => 50]);
        (yield 'odd' => ['cachedNodesByStringCountMax' => 51, 'cachedNodesByStringCountExpected' => 51]);
    }
    /**
     * @return Parser&\PHPUnit\Framework\MockObject\MockObject
     */
    private function getParserMock() : \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser
    {
        $mock = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser::class);
        $mock->method('parseFile')->willReturn([$this->getPhpParserNodeMock()]);
        $mock->method('parseString')->willReturn([$this->getPhpParserNodeMock()]);
        return $mock;
    }
    /**
     * @return \PhpParser\Node&\PHPUnit\Framework\MockObject\MockObject
     */
    private function getPhpParserNodeMock() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node
    {
        return $this->createMock(\TenantCloud\BetterReflection\Relocated\PhpParser\Node::class);
    }
    public function testParseTheSameFileWithDifferentMethod() : void
    {
        $parser = new \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\CachedParser(self::getContainer()->getService('pathRoutingParser'), 500);
        $path = __DIR__ . '/data/test.php';
        $contents = \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader::read($path);
        $stmts = $parser->parseString($contents);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_::class, $stmts[0]);
        $this->assertNull($stmts[0]->stmts[0]->getAttribute('parent'));
        $stmts = $parser->parseFile($path);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_::class, $stmts[0]);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_::class, $stmts[0]->stmts[0]->getAttribute('parent'));
        $stmts = $parser->parseString($contents);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_::class, $stmts[0]);
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_::class, $stmts[0]->stmts[0]->getAttribute('parent'));
    }
}
