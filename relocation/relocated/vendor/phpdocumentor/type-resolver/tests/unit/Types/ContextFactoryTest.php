<?php

declare (strict_types=1);
/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */
namespace TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types;

// Added imports on purpose as mock for the unit tests, please do not remove.
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen as m, TenantCloud\BetterReflection\Relocated\phpDocumentor;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\DocBlock;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\DocBlock\Tag;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
// yes, the slash is part of the test
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\Assert;
// yes, the slash is part of the test
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\Exception as e;
use ReflectionClass;
use stdClass;
/**
 * @coversDefaultClass \phpDocumentor\Reflection\Types\ContextFactory
 * @covers ::<private>
 */
class ContextFactoryTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @covers ::createFromReflector
     * @covers ::createForNamespace
     * @uses phpDocumentor\Reflection\Types\Context
     */
    public function testReadsNamespaceFromClassReflection() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory();
        $context = $fixture->createFromReflector(new \ReflectionClass($this));
        $this->assertSame(__NAMESPACE__, $context->getNamespace());
    }
    /**
     * @covers ::createFromReflector
     * @covers ::createForNamespace
     * @uses phpDocumentor\Reflection\Types\Context
     */
    public function testReadsAliasesFromClassReflection() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory();
        $context = $fixture->createFromReflector(new \ReflectionClass($this));
        $this->assertNamespaceAliasesFrom($context);
    }
    /**
     * @covers ::createForNamespace
     * @uses phpDocumentor\Reflection\Types\Context
     */
    public function testReadsNamespaceFromProvidedNamespaceAndContent() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory();
        $context = $fixture->createForNamespace(__NAMESPACE__, \file_get_contents(__FILE__));
        $this->assertSame(__NAMESPACE__, $context->getNamespace());
    }
    /**
     * @covers ::createForNamespace
     * @uses phpDocumentor\Reflection\Types\Context
     */
    public function testReadsAliasesFromProvidedNamespaceAndContent() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory();
        $context = $fixture->createForNamespace(__NAMESPACE__, \file_get_contents(__FILE__));
        $this->assertNamespaceAliasesFrom($context);
    }
    /**
     * @covers ::createForNamespace
     * @uses phpDocumentor\Reflection\Types\Context
     */
    public function testTraitUseIsNotDetectedAsNamespaceUse() : void
    {
        $php = '<?php declare(strict_types=1);
                namespace Foo;

                trait FooTrait {}

                class FooClass {
                    use FooTrait;
                }
            ';
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory();
        $context = $fixture->createForNamespace('Foo', $php);
        $this->assertSame([], $context->getNamespaceAliases());
    }
    /**
     * @covers ::createForNamespace
     * @uses phpDocumentor\Reflection\Types\Context
     */
    public function testAllOpeningBracesAreCheckedWhenSearchingForEndOfClass() : void
    {
        $php = '<?php declare(strict_types=1);
                namespace Foo;

                trait FooTrait {}
                trait BarTrait {}

                class FooClass {
                    use FooTrait;

                    public function bar()
                    {
                        echo "{$baz}";
                        echo "${baz}";
                    }
                }

                class BarClass {
                    use BarTrait;

                    public function bar()
                    {
                        echo "{$baz}";
                        echo "${baz}";
                    }
                }
            ';
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory();
        $context = $fixture->createForNamespace('Foo', $php);
        $this->assertSame([], $context->getNamespaceAliases());
    }
    /**
     * @covers ::createFromReflector
     */
    public function testEmptyFileName() : void
    {
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory();
        $context = $fixture->createFromReflector(new \ReflectionClass(\stdClass::class));
        $this->assertSame([], $context->getNamespaceAliases());
    }
    /**
     * @covers ::createFromReflector
     */
    public function testEvalDClass() : void
    {
        eval(<<<PHP
namespace Foo;

class Bar
{
}
PHP
);
        $fixture = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory();
        $context = $fixture->createFromReflector(new \ReflectionClass('TenantCloud\\BetterReflection\\Relocated\\Foo\\Bar'));
        $this->assertSame([], $context->getNamespaceAliases());
    }
    public function assertNamespaceAliasesFrom(\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context $context)
    {
        $expected = ['m' => \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen::class, 'DocBlock' => \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\DocBlock::class, 'Tag' => \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\DocBlock\Tag::class, 'phpDocumentor' => 'phpDocumentor', 'TestCase' => \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase::class, 'Assert' => \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\Assert::class, 'e' => \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\Exception::class, \ReflectionClass::class => \ReflectionClass::class, 'stdClass' => 'stdClass'];
        $actual = $context->getNamespaceAliases();
        // sort so that order differences don't break it
        \asort($expected);
        \asort($actual);
        $this->assertSame($expected, $actual);
    }
}
namespace TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Mock;

// the following import should not show in the tests above
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\AbstractList;
class Foo extends \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\AbstractList
{
    // dummy class
}
