<?php

namespace TenantCloud\BetterReflection\Relocated\NonEmptyArray;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param non-empty-array $array
     * @param non-empty-list $list
     * @param non-empty-array<int, string> $arrayOfStrings
     * @param non-empty-list<\stdClass> $listOfStd
     * @param non-empty-list<\stdClass> $listOfStd2
     * @param non-empty-list<string, \stdClass> $invalidList
     */
    public function doFoo(array $array, array $list, array $arrayOfStrings, array $listOfStd, $listOfStd2, array $invalidList, $invalidList2) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array&nonEmpty', $array);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, mixed>&nonEmpty', $list);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>&nonEmpty', $arrayOfStrings);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, stdClass>&nonEmpty', $listOfStd);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, stdClass>&nonEmpty', $listOfStd2);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', $invalidList);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $invalidList2);
    }
}
