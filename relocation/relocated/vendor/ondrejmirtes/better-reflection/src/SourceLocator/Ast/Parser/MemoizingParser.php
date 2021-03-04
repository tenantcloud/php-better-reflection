<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Parser;

use TenantCloud\BetterReflection\Relocated\PhpParser\ErrorHandler;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Parser;
use function array_key_exists;
use function hash;
use function strlen;
/**
 * @internal
 */
final class MemoizingParser implements \TenantCloud\BetterReflection\Relocated\PhpParser\Parser
{
    /** @var Node\Stmt[][]|null[] indexed by source hash */
    private $sourceHashToAst = [];
    /** @var Parser */
    private $wrappedParser;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Parser $wrappedParser)
    {
        $this->wrappedParser = $wrappedParser;
    }
    /**
     * {@inheritDoc}
     */
    public function parse(string $code, ?\TenantCloud\BetterReflection\Relocated\PhpParser\ErrorHandler $errorHandler = null) : ?array
    {
        // note: this code is mathematically buggy by default, as we are using a hash to identify
        //       cache entries. The string length is added to further reduce likeliness (although
        //       already imperceptible) of key collisions.
        //       In the "real world", this code will work just fine.
        $hash = \hash('sha256', $code) . ':' . \strlen($code);
        if (\array_key_exists($hash, $this->sourceHashToAst)) {
            return $this->sourceHashToAst[$hash];
        }
        return $this->sourceHashToAst[$hash] = $this->wrappedParser->parse($code, $errorHandler);
    }
}
