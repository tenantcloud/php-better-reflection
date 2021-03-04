#!/usr/bin/env php
<?php 
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor\NameResolver;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor\NodeConnectingVisitor;
use TenantCloud\BetterReflection\Relocated\PhpParser\ParserFactory;
(function () {
    require_once __DIR__ . '/../vendor/autoload.php';
    $parser = (new \TenantCloud\BetterReflection\Relocated\PhpParser\ParserFactory())->create(\TenantCloud\BetterReflection\Relocated\PhpParser\ParserFactory::ONLY_PHP7);
    $finder = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Finder();
    $finder->in(__DIR__ . '/../vendor/jetbrains/phpstorm-stubs')->files()->name('*.php');
    $visitor = new class extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract
    {
        /** @var string[] */
        public $functions = [];
        /** @var string[] */
        public $methods = [];
        public function enterNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
        {
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_) {
                foreach ($node->attrGroups as $attrGroup) {
                    foreach ($attrGroup->attrs as $attr) {
                        if ($attr->name->toString() === \TenantCloud\BetterReflection\Relocated\JetBrains\PhpStorm\Pure::class) {
                            $this->functions[] = $node->namespacedName->toLowerString();
                            break;
                        }
                    }
                }
            }
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod) {
                $class = $node->getAttribute('parent');
                if (!$class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike) {
                    throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException($node->name->toString());
                }
                $className = $class->namespacedName->toString();
                foreach ($node->attrGroups as $attrGroup) {
                    foreach ($attrGroup->attrs as $attr) {
                        if ($attr->name->toString() === \TenantCloud\BetterReflection\Relocated\JetBrains\PhpStorm\Pure::class) {
                            $this->methods[] = \sprintf('%s::%s', $className, $node->name->toString());
                            break;
                        }
                    }
                }
            }
            return null;
        }
    };
    foreach ($finder as $stubFile) {
        $path = $stubFile->getPathname();
        $traverser = new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser();
        $traverser->addVisitor(new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor\NameResolver());
        $traverser->addVisitor(new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor\NodeConnectingVisitor());
        $traverser->addVisitor($visitor);
        $traverser->traverse($parser->parse(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader::read($path)));
    }
    $metadata = (require __DIR__ . '/functionMetadata_original.php');
    foreach ($visitor->functions as $functionName) {
        if (\array_key_exists($functionName, $metadata)) {
            if ($metadata[$functionName]['hasSideEffects']) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException($functionName);
            }
        }
        $metadata[$functionName] = ['hasSideEffects' => \false];
    }
    foreach ($visitor->methods as $methodName) {
        if (\array_key_exists($methodName, $metadata)) {
            if ($metadata[$methodName]['hasSideEffects']) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException($methodName);
            }
        }
        $metadata[$methodName] = ['hasSideEffects' => \false];
    }
    \ksort($metadata);
    $template = <<<'php'
<?php declare(strict_types = 1);

return [
%s
];
php;
    $content = '';
    foreach ($metadata as $name => $meta) {
        $content .= \sprintf("\t%s => [%s => %s],\n", \var_export($name, \true), \var_export('hasSideEffects', \true), \var_export($meta['hasSideEffects'], \true));
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileWriter::write(__DIR__ . '/../resources/functionMetadata.php', \sprintf($template, $content));
})();
