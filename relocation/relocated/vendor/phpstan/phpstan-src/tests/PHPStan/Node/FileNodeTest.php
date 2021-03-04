<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
class FileNodeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new class implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
        {
            public function getNodeType() : string
            {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Node\FileNode::class;
            }
            /**
             * @param \PHPStan\Node\FileNode $node
             * @param \PHPStan\Analyser\Scope $scope
             * @return \PHPStan\Rules\RuleError[]
             */
            public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
            {
                $nodes = $node->getNodes();
                $pathHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper(__DIR__ . \DIRECTORY_SEPARATOR . 'data');
                if (!isset($nodes[0])) {
                    return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('File %s is empty.', $pathHelper->getRelativePath($scope->getFile())))->line(1)->build()];
                }
                return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('First node in file %s is: %s', $pathHelper->getRelativePath($scope->getFile()), \get_class($nodes[0])))->build()];
            }
        };
    }
    public function dataRule() : iterable
    {
        (yield [__DIR__ . '/data/empty.php', 'File empty.php is empty.', 1]);
        (yield [__DIR__ . '/data/declare.php', 'TenantCloud\\BetterReflection\\Relocated\\First node in file declare.php is: PhpParser\\Node\\Stmt\\Declare_', 1]);
        (yield [__DIR__ . '/data/namespace.php', 'TenantCloud\\BetterReflection\\Relocated\\First node in file namespace.php is: PhpParser\\Node\\Stmt\\Namespace_', 3]);
    }
    /**
     * @dataProvider dataRule
     * @param string $file
     * @param string $expectedError
     * @param int $line
     */
    public function testRule(string $file, string $expectedError, int $line) : void
    {
        $this->analyse([$file], [[$expectedError, $line]]);
    }
}
