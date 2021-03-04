<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceStubber;

use TenantCloud\BetterReflection\Relocated\PhpParser\Lexer\Emulative;
use TenantCloud\BetterReflection\Relocated\PhpParser\ParserFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
class Php8StubsSourceStubberTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testClass() : void
    {
        /** @var ClassReflector $classReflector */
        [$classReflector] = $this->getReflectors();
        $reflection = $classReflector->reflect(\Throwable::class);
        $this->assertSame(\Throwable::class, $reflection->getName());
    }
    public function testFunction() : void
    {
        /** @var FunctionReflector $functionReflector */
        [, $functionReflector] = $this->getReflectors();
        $reflection = $functionReflector->reflect('htmlspecialchars');
        $this->assertSame('htmlspecialchars', $reflection->getName());
    }
    /**
     * @return array{ClassReflector, FunctionReflector}
     */
    private function getReflectors() : array
    {
        // memoizing parser screws things up so we need to create the universe from the start
        $parser = (new \TenantCloud\BetterReflection\Relocated\PhpParser\ParserFactory())->create(\TenantCloud\BetterReflection\Relocated\PhpParser\ParserFactory::PREFER_PHP7, new \TenantCloud\BetterReflection\Relocated\PhpParser\Lexer\Emulative(['usedAttributes' => ['comments', 'startLine', 'endLine', 'startFilePos', 'endFilePos']]));
        /** @var FunctionReflector $functionReflector */
        $functionReflector = null;
        $astLocator = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator($parser, static function () use(&$functionReflector) : FunctionReflector {
            return $functionReflector;
        });
        $sourceStubber = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceStubber\Php8StubsSourceStubber();
        $phpInternalSourceLocator = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $sourceStubber);
        $classReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector($phpInternalSourceLocator);
        $functionReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector($phpInternalSourceLocator, $classReflector);
        return [$classReflector, $functionReflector];
    }
}
