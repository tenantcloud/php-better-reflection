<?php

namespace TenantCloud\BetterReflection\Relocated;

function () {
    if (\TenantCloud\BetterReflection\Relocated\foo()) {
        $ifVar = 1;
        $issetFoo = new \TenantCloud\BetterReflection\Relocated\Foo();
        $maybeDefinedButLaterCertainlyDefined = 1;
        if ($test) {
            $ifNestedVar = 1;
            $ifNotNestedVar = 1;
        } elseif (\TenantCloud\BetterReflection\Relocated\fooBar()) {
            $ifNotNestedVar = 2;
            $variableOnlyInEarlyTerminatingElse = 1;
            throw $e;
        } else {
            $ifNestedVar = 2;
        }
        $ifNotVar = 1;
    } elseif (\TenantCloud\BetterReflection\Relocated\bar()) {
        $ifVar = 2;
        $issetFoo = null;
        $ifNestedVar = 2;
        $ifNotNestedVar = 2;
        $ifNotVar = 2;
    } elseif ($ifNestedVar = 3) {
        $ifVar = 3;
        $ifNotNestedVar = 3;
    } else {
        $variableOnlyInEarlyTerminatingElse = 1;
        return;
    }
    if (\TenantCloud\BetterReflection\Relocated\foo()) {
        $maybeDefinedButLaterCertainlyDefined = 2;
    } else {
        $maybeDefinedButLaterCertainlyDefined = 3;
    }
    $exceptionFromTry = null;
    try {
        $inTry = 1;
        $inTryNotInCatch = 1;
        $fooObjectFromTryCatch = new \TenantCloud\BetterReflection\Relocated\InTryCatchFoo();
        $mixedVarFromTryCatch = 1;
        $nullableIntegerFromTryCatch = 1;
        $anotherNullableIntegerFromTryCatch = null;
        $someVariableThatWillGetOverrideInFinally = 1;
    } catch (\TenantCloud\BetterReflection\Relocated\SomeConcreteException $e) {
        $inTry = 1;
        $fooObjectFromTryCatch = new \TenantCloud\BetterReflection\Relocated\InTryCatchFoo();
        $mixedVarFromTryCatch = 1.0;
        $nullableIntegerFromTryCatch = null;
        $anotherNullableIntegerFromTryCatch = 1;
    } catch (\Exception $e) {
        throw $e;
    } finally {
        $someVariableThatWillGetOverrideInFinally = 'foo';
        \restore_error_handler();
    }
    $exceptionFromTryCatch = null;
    try {
    } catch (\TenantCloud\BetterReflection\Relocated\SomeConcreteException $exceptionFromTryCatch) {
        return;
    } catch (\TenantCloud\BetterReflection\Relocated\AnotherException $exceptionFromTryCatch) {
    } catch (\TenantCloud\BetterReflection\Relocated\YetAnotherException $exceptionFromTryCatch) {
        \TenantCloud\BetterReflection\Relocated\doFoo();
    }
    $lorem = 1;
    $arrOne[] = 'one';
    $arrTwo['test'] = 'two';
    $anotherArray['test'][] = 'another';
    \TenantCloud\BetterReflection\Relocated\doSomething($one, $callParameter = 3);
    $arrTwo[] = new \TenantCloud\BetterReflection\Relocated\Foo([$inArray = 1]);
    $arrThree = null;
    $arrThree[] = 'three';
    \preg_match('#.*#', 'foo', $matches);
    if ((bool) \preg_match('#.*#', 'foo', $matches3)) {
        \TenantCloud\BetterReflection\Relocated\foo();
    } elseif (\preg_match('#.*#', 'foo', $matches4)) {
        \TenantCloud\BetterReflection\Relocated\foo();
    }
    $trueOrFalseFromSwitch = \true;
    switch (\TenantCloud\BetterReflection\Relocated\foo()) {
        case 1:
            $switchVar = 1;
            $noSwitchVar = 1;
            $trueOrFalseFromSwitch = \false;
            break;
        case 'foo':
            $trueOrFalseFromSwitch = 1;
            return;
        case 2:
            $switchVar = 2;
            break;
        case 3:
            $anotherNoSwitchVar = 1;
        case 4:
        default:
            $switchVar = 3;
            if (\TenantCloud\BetterReflection\Relocated\doFoo()) {
                $switchVar = 4;
                break;
            }
    }
    $trueOrFalseInSwitchWithDefault = \false;
    $nullableTrueOrFalse = null;
    switch ('foo') {
        case 'foo':
            $trueOrFalseInSwitchWithDefault = \true;
            $nullableTrueOrFalse = \true;
            continue;
        case 'bar':
            $nullableTrueOrFalse = \false;
            break;
        default:
            break;
    }
    $trueOrFalseInSwitchInAllCases = \false;
    switch ('foo') {
        case 'foo':
            $trueOrFalseInSwitchInAllCases = \true;
            break;
        case 'bar':
            $trueOrFalseInSwitchInAllCases = \true;
            break;
    }
    $trueOrFalseInSwitchInAllCasesWithDefault = \false;
    switch ('foo') {
        case 'foo':
            $trueOrFalseInSwitchInAllCasesWithDefault = \true;
            break;
        case 'bar':
            $trueOrFalseInSwitchInAllCasesWithDefault = \true;
            break;
        default:
            break;
    }
    $trueOrFalseInSwitchInAllCasesWithDefaultCase = \false;
    switch ('foo') {
        case 'foo':
            $trueOrFalseInSwitchInAllCasesWithDefaultCase = \true;
            break;
        case 'bar':
            $trueOrFalseInSwitchInAllCasesWithDefaultCase = \true;
            break;
        default:
            $trueOrFalseInSwitchInAllCasesWithDefaultCase = \true;
            break;
    }
    switch ('foo') {
        case 'foo':
            $variableDefinedInSwitchWithOtherCasesWithEarlyTermination = \true;
            break;
        case 'bar':
            throw new \Exception();
        default:
            throw new \Exception();
    }
    switch ('foo') {
        case 'foo':
            throw new \Exception();
        case 'bar':
            $anotherVariableDefinedInSwitchWithOtherCasesWithEarlyTermination = \true;
            break;
        default:
            throw new \Exception();
    }
    switch ('foo') {
        case 'foo':
            $variableDefinedOnlyInEarlyTerminatingSwitchCases = \true;
            throw new \Exception();
        case 'bar':
            $variableDefinedOnlyInEarlyTerminatingSwitchCases = \true;
            return;
        case 'baz':
            break;
        default:
            $variableDefinedOnlyInEarlyTerminatingSwitchCases = \true;
            return;
    }
    switch ('foo') {
        case 'a':
            $variableDefinedInSwitchWithoutEarlyTermination = \true;
        case 'b':
            $variableDefinedInSwitchWithoutEarlyTermination = \false;
    }
    switch ('foo') {
        case 'a':
            $anotherVariableDefinedInSwitchWithoutEarlyTermination = \true;
            break;
        case 'b':
            $anotherVariableDefinedInSwitchWithoutEarlyTermination = \false;
    }
    switch (\TenantCloud\BetterReflection\Relocated\doFoo()) {
        case 1:
        case 2:
        case 3:
            $alwaysDefinedFromSwitch = 1;
            break;
        default:
            $alwaysDefinedFromSwitch = null;
    }
    $nullOverwrittenInSwitchToOne = null;
    switch (\TenantCloud\BetterReflection\Relocated\doFoo()) {
        case 1:
            if (\TenantCloud\BetterReflection\Relocated\doFoo()) {
                throw new \Exception();
            }
            $nullOverwrittenInSwitchToOne = 1;
            break;
        default:
            throw new \Exception();
    }
    switch (\TenantCloud\BetterReflection\Relocated\doFoo()) {
        case 1:
            if (\rand(0, 1)) {
                $variableFromSwitchShouldBeBool = \true;
                break;
            }
        default:
            $variableFromSwitchShouldBeBool = \false;
    }
    do {
        $doWhileVar = 1;
    } while (\TenantCloud\BetterReflection\Relocated\something());
    $integerOrNullFromFor = null;
    for ($previousI = 0, $previousJ = 0; $previousI < 1; $previousI++) {
        $integerOrNullFromFor = 1;
        $nonexistentVariableOutsideFor = 1;
    }
    $integerOrNullFromWhile = null;
    while (($frame = $that->getReader()->consumeFrame($that->getReadBuffer())) === null) {
        $integerOrNullFromWhile = 1;
        $nonexistentVariableOutsideWhile = 1;
    }
    /** @var array $someArray */
    $someArray = \TenantCloud\BetterReflection\Relocated\doFoo();
    $integerOrNullFromForeach = null;
    foreach ($someArray as $someValue) {
        $integerOrNullFromForeach = 1;
        $nonexistentVariableOutsideForeach = null;
    }
    $nullableIntegers = [1, 2, 3];
    $nullableIntegers[] = null;
    $union = [1, 2, 3];
    $union[] = 'foo';
    ${$lorem} = 'ipsum';
    $trueOrFalse = \true;
    $falseOrTrue = \false;
    $true = \true;
    $false = \false;
    if (\TenantCloud\BetterReflection\Relocated\doFoo()) {
        $trueOrFalse = \false;
        $falseOrTrue = \true;
        $true = \true;
        $false = \false;
    }
    /** @var string|null $notNullableString */
    $notNullableString = 'foo';
    if ($notNullableString === null) {
        return;
    }
    /** @var string|null $anotherNotNullableString */
    $anotherNotNullableString = 'foo';
    if ($anotherNotNullableString !== null) {
        $alsoNotNullableString = $anotherNotNullableString;
    } else {
        return;
    }
    /** @var Foo|null $notNullableObject */
    $notNullableObject = \TenantCloud\BetterReflection\Relocated\doFoo();
    if ($notNullableObject === null) {
        $notNullableObject = new \TenantCloud\BetterReflection\Relocated\Foo();
    }
    /** @var string|null $nullableString */
    $nullableString = 'foo';
    if ($nullableString !== null) {
        $whatever = $nullableString;
    }
    /** @var int|null $integerOrString */
    $integerOrString = 1;
    if ($integerOrString === null) {
        $integerOrString = 'str';
    }
    /** @var int|null $stillNullableInteger */
    $stillNullableInteger = 1;
    if (\is_int($stillNullableInteger)) {
        $stillNullableInteger = 2;
    }
    /** @var int|null $nullableIntegerAfterNeverCondition */
    $nullableIntegerAfterNeverCondition = 1;
    if ($nullableIntegerAfterNeverCondition === \false) {
        $nullableIntegerAfterNeverCondition = 1;
    }
    $arrayOfIntegers = [1, 2, 3];
    $arrayAccessObject = new \TenantCloud\BetterReflection\Relocated\ObjectWithArrayAccess\Foo();
    $arrayAccessObject[] = 1;
    $arrayAccessObject[] = 2;
    $width = 1;
    $scale = 2.0;
    $width *= $scale;
    /** @var mixed $mixed */
    $mixed = \TenantCloud\BetterReflection\Relocated\doFoo();
    if (\is_bool($mixed)) {
        $mixed = 1;
    }
    if (\rand(0, 1)) {
        /** @var mixed $issetBar */
        $issetBar = \TenantCloud\BetterReflection\Relocated\doFoo();
        /** @var mixed $issetBaz */
        $issetBaz = \TenantCloud\BetterReflection\Relocated\doFoo();
    }
    try {
        $inTryTwo = 1;
    } catch (\Exception $e) {
        $exception = $e;
        if (\TenantCloud\BetterReflection\Relocated\something()) {
            \TenantCloud\BetterReflection\Relocated\bar();
        } elseif (\TenantCloud\BetterReflection\Relocated\foo() || ($foo = \TenantCloud\BetterReflection\Relocated\exists() || \preg_match('#.*#', $subject, $matches2))) {
            if (isset($issetFoo, $issetBar) && isset($issetBaz)) {
                $anotherF = 1;
                for ($i = 0; $i < 5; $i++, $f = $i, $anotherF = $i) {
                    $arr = [[1, 2]];
                    foreach ($arr as list($listOne, $listTwo)) {
                        if (\is_array($arrayOfIntegers)) {
                            (bool) \preg_match('~.*~', $attributes, $ternaryMatches) ? die : null;
                        }
                    }
                }
            }
        }
    }
};
