<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection;

use TenantCloud\BetterReflection\Relocated\PhpParser\Lexer\Emulative;
use TenantCloud\BetterReflection\Relocated\PhpParser\Parser;
use TenantCloud\BetterReflection\Relocated\PhpParser\ParserFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator as AstLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Parser\MemoizingParser;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\AggregateSourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\SourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AutoloadSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\FindReflectionOnLine;
use const PHP_VERSION_ID;
final class BetterReflection
{
    /** @var int */
    public static $phpVersion = \PHP_VERSION_ID;
    /** @var SourceLocator|null */
    private static $sharedSourceLocator;
    /** @var SourceLocator|null */
    private $sourceLocator;
    /** @var ClassReflector|null */
    private static $sharedClassReflector;
    /** @var ClassReflector|null */
    private $classReflector;
    /** @var FunctionReflector|null */
    private static $sharedFunctionReflector;
    /** @var FunctionReflector|null */
    private $functionReflector;
    /** @var ConstantReflector|null */
    private static $sharedConstantReflector;
    /** @var ConstantReflector|null */
    private $constantReflector;
    /** @var Parser|null */
    private static $sharedPhpParser;
    /** @var Parser|null */
    private $phpParser;
    /** @var SourceStubber|null */
    private static $sharedSourceStubber;
    /** @var SourceStubber|null */
    private $sourceStubber;
    /** @var AstLocator|null */
    private $astLocator;
    /** @var FindReflectionOnLine|null */
    private $findReflectionOnLine;
    public static function populate(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector $classReflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector $functionReflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector $constantReflector, \TenantCloud\BetterReflection\Relocated\PhpParser\Parser $phpParser, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\SourceStubber $sourceStubber) : void
    {
        self::$sharedSourceLocator = $sourceLocator;
        self::$sharedClassReflector = $classReflector;
        self::$sharedFunctionReflector = $functionReflector;
        self::$sharedConstantReflector = $constantReflector;
        self::$sharedPhpParser = $phpParser;
        self::$sharedSourceStubber = $sourceStubber;
    }
    public function __construct()
    {
        $this->sourceLocator = self::$sharedSourceLocator;
        $this->classReflector = self::$sharedClassReflector;
        $this->functionReflector = self::$sharedFunctionReflector;
        $this->constantReflector = self::$sharedConstantReflector;
        $this->phpParser = self::$sharedPhpParser;
        $this->sourceStubber = self::$sharedSourceStubber;
    }
    public function sourceLocator() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator
    {
        $astLocator = $this->astLocator();
        $sourceStubber = $this->sourceStubber();
        return $this->sourceLocator ?? ($this->sourceLocator = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator([new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $sourceStubber), new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator($astLocator, $sourceStubber), new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AutoloadSourceLocator($astLocator, $this->phpParser())])));
    }
    public function classReflector() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector
    {
        return $this->classReflector ?? ($this->classReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector($this->sourceLocator()));
    }
    public function functionReflector() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector
    {
        return $this->functionReflector ?? ($this->functionReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector($this->sourceLocator(), $this->classReflector()));
    }
    public function constantReflector() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector
    {
        return $this->constantReflector ?? ($this->constantReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector($this->sourceLocator(), $this->classReflector()));
    }
    public function phpParser() : \TenantCloud\BetterReflection\Relocated\PhpParser\Parser
    {
        return $this->phpParser ?? ($this->phpParser = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Parser\MemoizingParser((new \TenantCloud\BetterReflection\Relocated\PhpParser\ParserFactory())->create(\TenantCloud\BetterReflection\Relocated\PhpParser\ParserFactory::PREFER_PHP7, new \TenantCloud\BetterReflection\Relocated\PhpParser\Lexer\Emulative(['usedAttributes' => ['comments', 'startLine', 'endLine', 'startFilePos', 'endFilePos']]))));
    }
    public function astLocator() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator
    {
        return $this->astLocator ?? ($this->astLocator = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator($this->phpParser(), function () : FunctionReflector {
            return $this->functionReflector();
        }));
    }
    public function findReflectionsOnLine() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\FindReflectionOnLine
    {
        return $this->findReflectionOnLine ?? ($this->findReflectionOnLine = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\FindReflectionOnLine($this->sourceLocator(), $this->astLocator()));
    }
    public function sourceStubber() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\SourceStubber
    {
        return $this->sourceStubber ?? ($this->sourceStubber = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\AggregateSourceStubber(new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber($this->phpParser(), self::$phpVersion), new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber()));
    }
}
