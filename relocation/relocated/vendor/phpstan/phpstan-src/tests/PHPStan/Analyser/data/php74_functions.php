<?php

namespace TenantCloud\BetterReflection\Relocated;

// mb_str_split
/** @var string $string */
$string = \TenantCloud\BetterReflection\Relocated\doFoo();
$mbStrSplitConstantStringWithoutDefinedParameters = \mb_str_split();
$mbStrSplitConstantStringWithoutDefinedSplitLength = \mb_str_split('abcdef');
$mbStrSplitStringWithoutDefinedSplitLength = \mb_str_split($string);
$mbStrSplitConstantStringWithOneSplitLength = \mb_str_split('abcdef', 1);
$mbStrSplitConstantStringWithGreaterSplitLengthThanStringLength = \mb_str_split('abcdef', 999);
$mbStrSplitConstantStringWithFailureSplitLength = \mb_str_split('abcdef', 0);
$mbStrSplitConstantStringWithInvalidSplitLengthType = \mb_str_split('abcdef', []);
$mbStrSplitConstantStringWithVariableStringAndConstantSplitLength = \mb_str_split(\TenantCloud\BetterReflection\Relocated\doFoo() ? 'abcdef' : 'ghijkl', 1);
$mbStrSplitConstantStringWithVariableStringAndVariableSplitLength = \mb_str_split(\TenantCloud\BetterReflection\Relocated\doFoo() ? 'abcdef' : 'ghijkl', \TenantCloud\BetterReflection\Relocated\doFoo() ? 1 : 2);
$mbStrSplitConstantStringWithOneSplitLengthAndValidEncoding = \mb_str_split('abcdef', 1, 'UTF-8');
$mbStrSplitConstantStringWithOneSplitLengthAndInvalidEncoding = \mb_str_split('abcdef', 1, 'FAKE');
$mbStrSplitConstantStringWithOneSplitLengthAndVariableEncoding = \mb_str_split('abcdef', 1, \TenantCloud\BetterReflection\Relocated\doFoo());
$mbStrSplitConstantStringWithGreaterSplitLengthThanStringLengthAndValidEncoding = \mb_str_split('abcdef', 999, 'UTF-8');
$mbStrSplitConstantStringWithGreaterSplitLengthThanStringLengthAndInvalidEncoding = \mb_str_split('abcdef', 999, 'FAKE');
$mbStrSplitConstantStringWithGreaterSplitLengthThanStringLengthAndVariableEncoding = \mb_str_split('abcdef', 999, \TenantCloud\BetterReflection\Relocated\doFoo());
$mbStrSplitConstantStringWithFailureSplitLengthAndValidEncoding = \mb_str_split('abcdef', 0, 'UTF-8');
$mbStrSplitConstantStringWithFailureSplitLengthAndInvalidEncoding = \mb_str_split('abcdef', 0, 'FAKE');
$mbStrSplitConstantStringWithFailureSplitLengthAndVariableEncoding = \mb_str_split('abcdef', 0, \TenantCloud\BetterReflection\Relocated\doFoo());
$mbStrSplitConstantStringWithInvalidSplitLengthTypeAndValidEncoding = \mb_str_split('abcdef', [], 'UTF-8');
$mbStrSplitConstantStringWithInvalidSplitLengthTypeAndInvalidEncoding = \mb_str_split('abcdef', [], 'FAKE');
$mbStrSplitConstantStringWithInvalidSplitLengthTypeAndVariableEncoding = \mb_str_split('abcdef', [], \TenantCloud\BetterReflection\Relocated\doFoo());
$mbStrSplitConstantStringWithVariableStringAndConstantSplitLengthAndValidEncoding = \mb_str_split(\TenantCloud\BetterReflection\Relocated\doFoo() ? 'abcdef' : 'ghijkl', 1, 'UTF-8');
$mbStrSplitConstantStringWithVariableStringAndConstantSplitLengthAndInvalidEncoding = \mb_str_split(\TenantCloud\BetterReflection\Relocated\doFoo() ? 'abcdef' : 'ghijkl', 1, 'FAKE');
$mbStrSplitConstantStringWithVariableStringAndConstantSplitLengthAndVariableEncoding = \mb_str_split(\TenantCloud\BetterReflection\Relocated\doFoo() ? 'abcdef' : 'ghijkl', 1, \TenantCloud\BetterReflection\Relocated\doFoo());
$mbStrSplitConstantStringWithVariableStringAndVariableSplitLengthAndValidEncoding = \mb_str_split(\TenantCloud\BetterReflection\Relocated\doFoo() ? 'abcdef' : 'ghijkl', \TenantCloud\BetterReflection\Relocated\doFoo() ? 1 : 2, 'UTF-8');
$mbStrSplitConstantStringWithVariableStringAndVariableSplitLengthAndInvalidEncoding = \mb_str_split(\TenantCloud\BetterReflection\Relocated\doFoo() ? 'abcdef' : 'ghijkl', \TenantCloud\BetterReflection\Relocated\doFoo() ? 1 : 2, 'FAKE');
$mbStrSplitConstantStringWithVariableStringAndVariableSplitLengthAndVariableEncoding = \mb_str_split(\TenantCloud\BetterReflection\Relocated\doFoo() ? 'abcdef' : 'ghijkl', \TenantCloud\BetterReflection\Relocated\doFoo() ? 1 : 2, \TenantCloud\BetterReflection\Relocated\doFoo());
die;
