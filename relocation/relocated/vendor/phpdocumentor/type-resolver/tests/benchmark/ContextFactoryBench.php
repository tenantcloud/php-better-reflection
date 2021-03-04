<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\benchmark;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory;
/**
 * @BeforeMethods({"setup"})
 */
final class ContextFactoryBench
{
    private $source;
    public function setup()
    {
        $this->source = \file_get_contents(__DIR__ . '/Assets/mpdf.php');
    }
    /**
     * @Warmup(1)
     * @Executor(
     *     "blackfire",
     *      assertions={
     *      {"expression"="main.peak_memory < 120Mb", "title"="memory peak"},
     *      "main.wall_time < 3S"
     *      }
     * )
     */
    public function benchCreateContextForNamespace()
    {
        $factory = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory();
        $factory->createForNamespace('Mpdf', $this->source);
    }
}
