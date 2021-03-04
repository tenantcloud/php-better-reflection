<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Bug4300;

class Widget
{
    public function getDefault() : int
    {
        $column1 = [];
        $column2 = [];
        $column = \count($column1) > \count($column2) ? 2 : 1;
        return $column;
    }
}
