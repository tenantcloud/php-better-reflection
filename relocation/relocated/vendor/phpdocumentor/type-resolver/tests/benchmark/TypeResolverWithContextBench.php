<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\benchmark;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory;
/**
 * @BeforeMethods({"setup"})
 */
final class TypeResolverWithContextBench
{
    /**
     * @var Context
     */
    private $context;
    /**
     * @var TypeResolver
     */
    private $typeResolver;
    public function setup()
    {
        $factory = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\ContextFactory();
        $this->context = $factory->createForNamespace('mpdf', \file_get_contents(__DIR__ . '/Assets/mpdf.php'));
        $this->typeResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
    }
    /**
     * @Warmup(2)
     * @Executor(
     *     "blackfire",
     *     assertions={
     *      {"expression"="main.peak_memory < 11kb", "title"="memory peak"},
     *      "main.wall_time < 1ms"
     *      }
     * )
     */
    public function benchResolveCompoundArrayWithDefinedTypes() : void
    {
        $this->typeResolver->resolve('array<int, string>|array<int, int>', $this->context);
    }
    /**
     * @Warmup(2)
     * @Executor(
     *     "blackfire",
     *     assertions={
     *      {"expression"="main.peak_memory < 11kb", "title"="memory peak"},
     *      "main.wall_time < 1ms"
     *      }
     * )
     */
    public function benchArrayOfClass() : void
    {
        $this->typeResolver->resolve('Conversion[]', $this->context);
    }
}
