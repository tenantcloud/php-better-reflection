<?php

// lint >= 7.4
namespace TenantCloud\BetterReflection\Relocated\Bug4188;

interface A
{
}
interface B
{
}
class Test
{
    /** @param array<A|B> $data */
    public function set(array $data) : void
    {
        $this->onlyB(\array_filter($data, function ($param) : bool {
            return $param instanceof \TenantCloud\BetterReflection\Relocated\Bug4188\B;
        }));
    }
    /** @param array<A|B> $data */
    public function setShort(array $data) : void
    {
        $this->onlyB(\array_filter($data, fn($param): bool => $param instanceof \TenantCloud\BetterReflection\Relocated\Bug4188\B));
    }
    /** @param B[] $data */
    public function onlyB(array $data) : void
    {
    }
}
