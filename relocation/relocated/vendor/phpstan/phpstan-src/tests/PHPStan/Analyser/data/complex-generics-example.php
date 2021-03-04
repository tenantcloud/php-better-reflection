<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\ComplexGenericsExample;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @template TVariant of VariantInterface
 */
interface ExperimentInterface
{
}
interface VariantInterface
{
}
interface VariantRetrieverInterface
{
    /**
     * @template TVariant of VariantInterface
     * @param ExperimentInterface<TVariant> $experiment
     * @return TVariant
     */
    public function getVariant(\TenantCloud\BetterReflection\Relocated\ComplexGenericsExample\ExperimentInterface $experiment) : \TenantCloud\BetterReflection\Relocated\ComplexGenericsExample\VariantInterface;
}
/**
 * @implements ExperimentInterface<SomeVariant>
 */
class SomeExperiment implements \TenantCloud\BetterReflection\Relocated\ComplexGenericsExample\ExperimentInterface
{
}
class SomeVariant implements \TenantCloud\BetterReflection\Relocated\ComplexGenericsExample\VariantInterface
{
}
class SomeClass
{
    private $variantRetriever;
    public function __construct(\TenantCloud\BetterReflection\Relocated\ComplexGenericsExample\VariantRetrieverInterface $variantRetriever)
    {
        $this->variantRetriever = $variantRetriever;
    }
    public function someFunction() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\ComplexGenericsExample\\SomeVariant', $this->variantRetriever->getVariant(new \TenantCloud\BetterReflection\Relocated\ComplexGenericsExample\SomeExperiment()));
    }
}
