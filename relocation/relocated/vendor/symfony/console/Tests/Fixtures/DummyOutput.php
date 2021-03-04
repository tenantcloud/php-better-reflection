<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Fixtures;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\BufferedOutput;
/**
 * Dummy output.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class DummyOutput extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\BufferedOutput
{
    public function getLogs() : array
    {
        $logs = [];
        foreach (\explode(\PHP_EOL, \trim($this->fetch())) as $message) {
            \preg_match('/^\\[(.*)\\] (.*)/', $message, $matches);
            $logs[] = \sprintf('%s %s', $matches[1], $matches[2]);
        }
        return $logs;
    }
}
