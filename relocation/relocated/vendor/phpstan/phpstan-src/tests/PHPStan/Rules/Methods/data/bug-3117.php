<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3117;

interface Temporal
{
    /**
     * @return static
     */
    public function adjustedWith(\TenantCloud\BetterReflection\Relocated\Bug3117\TemporalAdjuster $adjuster) : \TenantCloud\BetterReflection\Relocated\Bug3117\Temporal;
}
interface TemporalAdjuster
{
    /**
     * @template T of Temporal
     *
     * @param T $temporal
     *
     * @return T
     */
    public function adjustInto(\TenantCloud\BetterReflection\Relocated\Bug3117\Temporal $temporal) : \TenantCloud\BetterReflection\Relocated\Bug3117\Temporal;
}
final class SimpleTemporal implements \TenantCloud\BetterReflection\Relocated\Bug3117\Temporal, \TenantCloud\BetterReflection\Relocated\Bug3117\TemporalAdjuster
{
    public function adjustInto(\TenantCloud\BetterReflection\Relocated\Bug3117\Temporal $temporal) : \TenantCloud\BetterReflection\Relocated\Bug3117\Temporal
    {
        if ($temporal instanceof self) {
            return $this;
        }
        return $temporal->adjustedWith($this);
    }
    /**
     * @return static
     */
    public function adjustedWith(\TenantCloud\BetterReflection\Relocated\Bug3117\TemporalAdjuster $adjuster) : \TenantCloud\BetterReflection\Relocated\Bug3117\Temporal
    {
        return $this;
    }
}
