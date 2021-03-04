<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
class UniversalObjectCratesClassReflectionExtensionTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testNonexistentClass() : void
    {
        $broker = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        $extension = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension(['NonexistentClass', 'stdClass']);
        $extension->setBroker($broker);
        $this->assertTrue($extension->hasProperty($broker->getClass(\stdClass::class), 'foo'));
    }
    public function testDifferentGetSetType() : void
    {
        require_once __DIR__ . '/data/universal-object-crates.php';
        $broker = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        $extension = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension(['TenantCloud\\BetterReflection\\Relocated\\UniversalObjectCreates\\DifferentGetSetTypes']);
        $extension->setBroker($broker);
        $this->assertEquals(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('TenantCloud\\BetterReflection\\Relocated\\UniversalObjectCreates\\DifferentGetSetTypesValue'), $extension->getProperty($broker->getClass('TenantCloud\\BetterReflection\\Relocated\\UniversalObjectCreates\\DifferentGetSetTypes'), 'foo')->getReadableType());
        $this->assertEquals(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), $extension->getProperty($broker->getClass('TenantCloud\\BetterReflection\\Relocated\\UniversalObjectCreates\\DifferentGetSetTypes'), 'foo')->getWritableType());
    }
}
