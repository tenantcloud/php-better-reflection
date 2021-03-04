<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PhpParser\Comment;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\Exception\UnableToCompileNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAnInterfaceReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
use TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\DependencyResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\FileNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FileRuleError;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\IdentifierRuleError;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\LineRuleError;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MetadataRuleError;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NonIgnorableRuleError;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Registry;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\TipRuleError;
use function array_key_exists;
use function array_unique;
class FileAnalyser
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory $scopeFactory;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\DependencyResolver $dependencyResolver;
    private bool $reportUnmatchedIgnoredErrors;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory $scopeFactory, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver, \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser, \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\DependencyResolver $dependencyResolver, bool $reportUnmatchedIgnoredErrors)
    {
        $this->scopeFactory = $scopeFactory;
        $this->nodeScopeResolver = $nodeScopeResolver;
        $this->parser = $parser;
        $this->dependencyResolver = $dependencyResolver;
        $this->reportUnmatchedIgnoredErrors = $reportUnmatchedIgnoredErrors;
    }
    /**
     * @param string $file
     * @param array<string, true> $analysedFiles
     * @param Registry $registry
     * @param callable(\PhpParser\Node $node, Scope $scope): void|null $outerNodeCallback
     * @return FileAnalyserResult
     */
    public function analyseFile(string $file, array $analysedFiles, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Registry $registry, ?callable $outerNodeCallback) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\FileAnalyserResult
    {
        $fileErrors = [];
        $fileDependencies = [];
        $exportedNodes = [];
        if (\is_file($file)) {
            try {
                $parserNodes = $this->parser->parseFile($file);
                $linesToIgnore = [];
                $temporaryFileErrors = [];
                $nodeCallback = function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) use(&$fileErrors, &$fileDependencies, &$exportedNodes, $file, $registry, $outerNodeCallback, $analysedFiles, &$linesToIgnore, &$temporaryFileErrors) : void {
                    if ($outerNodeCallback !== null) {
                        $outerNodeCallback($node, $scope);
                    }
                    $uniquedAnalysedCodeExceptionMessages = [];
                    $nodeType = \get_class($node);
                    foreach ($registry->getRules($nodeType) as $rule) {
                        try {
                            $ruleErrors = $rule->processNode($node, $scope);
                        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\AnalysedCodeException $e) {
                            if (isset($uniquedAnalysedCodeExceptionMessages[$e->getMessage()])) {
                                continue;
                            }
                            $uniquedAnalysedCodeExceptionMessages[$e->getMessage()] = \true;
                            $fileErrors[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error($e->getMessage(), $file, $node->getLine(), $e, null, null, $e->getTip());
                            continue;
                        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                            $fileErrors[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error(\sprintf('Reflection error: %s not found.', $e->getIdentifier()->getName()), $file, $node->getLine(), $e, null, null, 'Learn more at https://phpstan.org/user-guide/discovering-symbols');
                            continue;
                        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAClassReflection|\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
                            $fileErrors[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error(\sprintf('Reflection error: %s', $e->getMessage()), $file, $node->getLine(), $e);
                            continue;
                        }
                        foreach ($ruleErrors as $ruleError) {
                            $nodeLine = $node->getLine();
                            $line = $nodeLine;
                            $canBeIgnored = \true;
                            $fileName = $scope->getFileDescription();
                            $filePath = $scope->getFile();
                            $traitFilePath = null;
                            $tip = null;
                            $identifier = null;
                            $metadata = [];
                            if ($scope->isInTrait()) {
                                $traitReflection = $scope->getTraitReflection();
                                if ($traitReflection->getFileName() !== \false) {
                                    $traitFilePath = $traitReflection->getFileName();
                                }
                            }
                            if (\is_string($ruleError)) {
                                $message = $ruleError;
                            } else {
                                $message = $ruleError->getMessage();
                                if ($ruleError instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\LineRuleError && $ruleError->getLine() !== -1) {
                                    $line = $ruleError->getLine();
                                }
                                if ($ruleError instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FileRuleError && $ruleError->getFile() !== '') {
                                    $fileName = $ruleError->getFile();
                                    $filePath = $ruleError->getFile();
                                    $traitFilePath = null;
                                }
                                if ($ruleError instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\TipRuleError) {
                                    $tip = $ruleError->getTip();
                                }
                                if ($ruleError instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\IdentifierRuleError) {
                                    $identifier = $ruleError->getIdentifier();
                                }
                                if ($ruleError instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MetadataRuleError) {
                                    $metadata = $ruleError->getMetadata();
                                }
                                if ($ruleError instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NonIgnorableRuleError) {
                                    $canBeIgnored = \false;
                                }
                            }
                            $temporaryFileErrors[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error($message, $fileName, $line, $canBeIgnored, $filePath, $traitFilePath, $tip, $nodeLine, $nodeType, $identifier, $metadata);
                        }
                    }
                    foreach ($this->getLinesToIgnore($node) as $lineToIgnore) {
                        $linesToIgnore[$scope->getFileDescription()][$lineToIgnore] = \true;
                    }
                    try {
                        $dependencies = $this->dependencyResolver->resolveDependencies($node, $scope);
                        foreach ($dependencies->getFileDependencies($scope->getFile(), $analysedFiles) as $dependentFile) {
                            $fileDependencies[] = $dependentFile;
                        }
                        if ($dependencies->getExportedNode() !== null) {
                            $exportedNodes[] = $dependencies->getExportedNode();
                        }
                    } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\AnalysedCodeException $e) {
                        // pass
                    } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                        // pass
                    } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAClassReflection|\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
                        // pass
                    }
                };
                $scope = $this->scopeFactory->create(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeContext::create($file));
                $nodeCallback(new \TenantCloud\BetterReflection\Relocated\PHPStan\Node\FileNode($parserNodes), $scope);
                $this->nodeScopeResolver->processNodes($parserNodes, $scope, $nodeCallback);
                $unmatchedLineIgnores = $linesToIgnore;
                foreach ($temporaryFileErrors as $tmpFileError) {
                    $line = $tmpFileError->getLine();
                    if ($line !== null && $tmpFileError->canBeIgnored() && \array_key_exists($tmpFileError->getFile(), $linesToIgnore) && \array_key_exists($line, $linesToIgnore[$tmpFileError->getFile()])) {
                        unset($unmatchedLineIgnores[$tmpFileError->getFile()][$line]);
                        continue;
                    }
                    $fileErrors[] = $tmpFileError;
                }
                if ($this->reportUnmatchedIgnoredErrors) {
                    foreach ($unmatchedLineIgnores as $ignoredFile => $lines) {
                        if ($ignoredFile !== $file) {
                            continue;
                        }
                        foreach (\array_keys($lines) as $line) {
                            $fileErrors[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error(\sprintf('No error to ignore is reported on line %d.', $line), $scope->getFileDescription(), $line, \false, $scope->getFile(), null, null, null, null, 'ignoredError.unmatchedOnLine');
                        }
                    }
                }
            } catch (\TenantCloud\BetterReflection\Relocated\PhpParser\Error $e) {
                $fileErrors[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error($e->getMessage(), $file, $e->getStartLine() !== -1 ? $e->getStartLine() : null, $e);
            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\ParserErrorsException $e) {
                foreach ($e->getErrors() as $error) {
                    $fileErrors[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error($error->getMessage(), $e->getParsedFile() ?? $file, $error->getStartLine() !== -1 ? $error->getStartLine() : null, $e);
                }
            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\AnalysedCodeException $e) {
                $fileErrors[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error($e->getMessage(), $file, null, $e, null, null, $e->getTip());
            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                $fileErrors[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error(\sprintf('Reflection error: %s not found.', $e->getIdentifier()->getName()), $file, null, $e, null, null, 'Learn more at https://phpstan.org/user-guide/discovering-symbols');
            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAClassReflection|\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
                $fileErrors[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error(\sprintf('Reflection error: %s', $e->getMessage()), $file, null, $e);
            }
        } elseif (\is_dir($file)) {
            $fileErrors[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error(\sprintf('File %s is a directory.', $file), $file, null, \false);
        } else {
            $fileErrors[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error(\sprintf('File %s does not exist.', $file), $file, null, \false);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\FileAnalyserResult($fileErrors, \array_values(\array_unique($fileDependencies)), $exportedNodes);
    }
    /**
     * @param Node $node
     * @return int[]
     */
    private function getLinesToIgnore(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) : array
    {
        $lines = [];
        if ($node->getDocComment() !== null) {
            $line = $this->findLineToIgnoreComment($node->getDocComment());
            if ($line !== null) {
                $lines[] = $line;
            }
        }
        foreach ($node->getComments() as $comment) {
            $line = $this->findLineToIgnoreComment($comment);
            if ($line === null) {
                continue;
            }
            $lines[] = $line;
        }
        return $lines;
    }
    private function findLineToIgnoreComment(\TenantCloud\BetterReflection\Relocated\PhpParser\Comment $comment) : ?int
    {
        $text = $comment->getText();
        if ($comment instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Comment\Doc) {
            $line = $comment->getEndLine();
        } else {
            if (\strpos($text, "\n") === \false || \strpos($text, '//') === 0) {
                $line = $comment->getStartLine();
            } else {
                $line = $comment->getEndLine();
            }
        }
        if (\strpos($text, '@phpstan-ignore-next-line') !== \false) {
            return $line + 1;
        }
        if (\strpos($text, '@phpstan-ignore-line') !== \false) {
            return $line;
        }
        return null;
    }
}
