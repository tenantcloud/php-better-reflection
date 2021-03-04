<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Fputcsv;

class Person
{
}
class PersonWithToString
{
    public function __toString() : string
    {
        return "to string name";
    }
}
class CsvWriter
{
    /** @param resource $handle */
    public function writeCsv($handle) : void
    {
        // These are all valid scalers
        \fputcsv($handle, ["string", 1, 3.5, \true, \false, null]);
        // Arrays can have string for keys (which are ignored)
        \fputcsv($handle, ["foo" => "bar"]);
        \fputcsv($handle, [new \TenantCloud\BetterReflection\Relocated\Fputcsv\Person()]);
        // Problem on this line
        // This is valid. PersonWithToString should be cast to string by fputcsv
        \fputcsv($handle, [new \TenantCloud\BetterReflection\Relocated\Fputcsv\PersonWithToString()]);
    }
}
