<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2927;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
abstract class Event
{
}
class MyEvent extends \TenantCloud\BetterReflection\Relocated\Bug2927\Event
{
}
function () : void {
    $reflect = new \ReflectionFunction('TenantCloud\\BetterReflection\\Relocated\\test\\handler');
    $paramClass = $reflect->getParameters()[0]->getClass();
    if ($paramClass === null or !$paramClass->isSubclassOf(\TenantCloud\BetterReflection\Relocated\Bug2927\Event::class)) {
        return;
    }
    /** @var \ReflectionClass<MyEvent> $paramClass */
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<Bug2927\\MyEvent>', $paramClass->getName());
    try {
        throw new \Exception();
    } catch (\Exception $e) {
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<Bug2927\\MyEvent>', $paramClass->getName());
};
