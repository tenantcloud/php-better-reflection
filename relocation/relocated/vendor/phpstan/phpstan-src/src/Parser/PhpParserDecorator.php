<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Parser;

use TenantCloud\BetterReflection\Relocated\PhpParser\ErrorHandler;
class PhpParserDecorator implements \TenantCloud\BetterReflection\Relocated\PhpParser\Parser
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $wrappedParser;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $wrappedParser)
    {
        $this->wrappedParser = $wrappedParser;
    }
    /**
     * @param string $code
     * @param \PhpParser\ErrorHandler|null $errorHandler
     * @return \PhpParser\Node\Stmt[]
     */
    public function parse(string $code, ?\TenantCloud\BetterReflection\Relocated\PhpParser\ErrorHandler $errorHandler = null) : array
    {
        try {
            return $this->wrappedParser->parseString($code);
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\ParserErrorsException $e) {
            $message = $e->getMessage();
            if ($e->getParsedFile() !== null) {
                $message .= \sprintf(' in file %s', $e->getParsedFile());
            }
            throw new \TenantCloud\BetterReflection\Relocated\PhpParser\Error($message);
        }
    }
}
