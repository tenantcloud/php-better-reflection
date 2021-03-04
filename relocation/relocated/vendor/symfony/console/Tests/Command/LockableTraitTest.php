<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Command;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Lock\LockFactory;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Lock\Store\FlockStore;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Lock\Store\SemaphoreStore;
class LockableTraitTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    protected static $fixturesPath;
    public static function setUpBeforeClass() : void
    {
        self::$fixturesPath = __DIR__ . '/../Fixtures/';
        require_once self::$fixturesPath . '/FooLockCommand.php';
        require_once self::$fixturesPath . '/FooLock2Command.php';
    }
    public function testLockIsReleased()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\FooLockCommand();
        $tester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($command);
        $this->assertSame(2, $tester->execute([]));
        $this->assertSame(2, $tester->execute([]));
    }
    public function testLockReturnsFalseIfAlreadyLockedByAnotherCommand()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\FooLockCommand();
        if (\TenantCloud\BetterReflection\Relocated\Symfony\Component\Lock\Store\SemaphoreStore::isSupported()) {
            $store = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Lock\Store\SemaphoreStore();
        } else {
            $store = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Lock\Store\FlockStore();
        }
        $lock = (new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Lock\LockFactory($store))->createLock($command->getName());
        $lock->acquire();
        $tester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($command);
        $this->assertSame(1, $tester->execute([]));
        $lock->release();
        $this->assertSame(2, $tester->execute([]));
    }
    public function testMultipleLockCallsThrowLogicException()
    {
        $command = new \TenantCloud\BetterReflection\Relocated\FooLock2Command();
        $tester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\CommandTester($command);
        $this->assertSame(1, $tester->execute([]));
    }
}
