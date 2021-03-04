<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\FputcsvPhp8;

class StringablePerson implements \Stringable
{
    public function __toString() : string
    {
        return "stringable name";
    }
}
class CsvWriterPhp8
{
    /** @param resource $handle */
    public function write($handle) : void
    {
        // This is valid. StringablePerson should be treated as a string
        \fputcsv($handle, [new \TenantCloud\BetterReflection\Relocated\FputcsvPhp8\StringablePerson()]);
    }
}
