<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

/*
 * This file is part of Evenement.
 *
 * (c) Igor Wiedler <igor@wiedler.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
const ITERATIONS = 10000000;
use TenantCloud\BetterReflection\Relocated\Evenement\EventEmitter;
require __DIR__ . '/../vendor/autoload.php';
$emitter = new \TenantCloud\BetterReflection\Relocated\Evenement\EventEmitter();
$emitter->on('event', function () {
});
$start = \microtime(\true);
for ($i = 0; $i < \ITERATIONS; $i++) {
    $emitter->emit('event');
}
$time = \microtime(\true) - $start;
echo 'Emitting ', \number_format(\ITERATIONS), ' events took: ', \number_format($time, 2), 's', \PHP_EOL;
