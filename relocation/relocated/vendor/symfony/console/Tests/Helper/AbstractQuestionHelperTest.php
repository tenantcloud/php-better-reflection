<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Helper;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StreamableInputInterface;
abstract class AbstractQuestionHelperTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    protected function createStreamableInputInterfaceMock($stream = null, $interactive = \true)
    {
        $mock = $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\StreamableInputInterface::class);
        $mock->expects($this->any())->method('isInteractive')->willReturn($interactive);
        if ($stream) {
            $mock->expects($this->any())->method('getStream')->willReturn($stream);
        }
        return $mock;
    }
}
