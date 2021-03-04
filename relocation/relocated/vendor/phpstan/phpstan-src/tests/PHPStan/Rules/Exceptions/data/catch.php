<?php

namespace TenantCloud\BetterReflection\Relocated\TestCatch;

class FooCatch
{
}
class MyCatchException extends \Exception
{
}
try {
} catch (\TenantCloud\BetterReflection\Relocated\TestCatch\FooCatch $e) {
    // not an exception
}
try {
} catch (\TenantCloud\BetterReflection\Relocated\TestCatch\MyCatchException $e) {
}
try {
} catch (\TenantCloud\BetterReflection\Relocated\FooCatchException $e) {
    // nonexistent exception class
}
try {
} catch (\TypeError $e) {
}
try {
} catch (\TenantCloud\BetterReflection\Relocated\TestCatch\MyCatchEXCEPTION $e) {
}
