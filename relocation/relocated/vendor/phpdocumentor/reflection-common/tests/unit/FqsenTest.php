<?php

declare (strict_types=1);
/**
 * phpDocumentor
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */
namespace TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection;

use InvalidArgumentException;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
/**
 * @coversDefaultClass \phpDocumentor\Reflection\Fqsen
 */
class FqsenTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @covers ::__construct
     * @dataProvider validFqsenProvider
     */
    public function testValidFormats(string $fqsen, string $name) : void
    {
        $instance = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen($fqsen);
        $this->assertEquals($name, $instance->getName());
    }
    /**
     * Data provider for ValidFormats tests. Contains a complete list from psr-5 draft.
     *
     * @return array<array<string>>
     */
    public function validFqsenProvider() : array
    {
        return [['\\', ''], ['TenantCloud\\BetterReflection\\Relocated\\My\\Space', 'Space'], ['\\My\\Space\\myFunction()', 'myFunction'], ['TenantCloud\\BetterReflection\\Relocated\\My\\Space\\MY_CONSTANT', 'MY_CONSTANT'], ['TenantCloud\\BetterReflection\\Relocated\\My\\Space\\MY_CONSTANT2', 'MY_CONSTANT2'], ['TenantCloud\\BetterReflection\\Relocated\\My\\Space\\MyClass', 'MyClass'], ['TenantCloud\\BetterReflection\\Relocated\\My\\Space\\MyInterface', 'MyInterface'], ['\\My\\Space\\Option«T»', 'Option«T»'], ['TenantCloud\\BetterReflection\\Relocated\\My\\Space\\MyTrait', 'MyTrait'], ['\\My\\Space\\MyClass::myMethod()', 'myMethod'], ['\\My\\Space\\MyClass::$my_property', 'my_property'], ['\\My\\Space\\MyClass::MY_CONSTANT', 'MY_CONSTANT']];
    }
    /**
     * @covers ::__construct
     * @dataProvider invalidFqsenProvider
     */
    public function testInValidFormats(string $fqsen) : void
    {
        $this->expectException(\InvalidArgumentException::class);
        new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen($fqsen);
    }
    /**
     * Data provider for invalidFormats tests. Contains a complete list from psr-5 draft.
     *
     * @return array<array<string>>
     */
    public function invalidFqsenProvider() : array
    {
        return [['\\My\\*'], ['\\My\\Space\\.()'], ['TenantCloud\\BetterReflection\\Relocated\\My\\Space'], ['1_function()']];
    }
    /**
     * @covers ::__construct
     * @covers ::__toString
     */
    public function testToString() : void
    {
        $className = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen('TenantCloud\\BetterReflection\\Relocated\\phpDocumentor\\Application');
        $this->assertEquals('TenantCloud\\BetterReflection\\Relocated\\phpDocumentor\\Application', (string) $className);
    }
}
