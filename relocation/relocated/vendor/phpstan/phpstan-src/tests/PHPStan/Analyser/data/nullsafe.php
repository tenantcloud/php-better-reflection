<?php

namespace TenantCloud\BetterReflection\Relocated\Nullsafe;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    private ?\TenantCloud\BetterReflection\Relocated\self $nullableSelf;
    private \TenantCloud\BetterReflection\Relocated\self $self;
    public function doFoo(?\Exception $e)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string|null', $e?->getMessage());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Exception|null', $e);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Throwable|null', $e?->getPrevious());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string|null', $e?->getPrevious()?->getMessage());
        $e?->getMessage(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Exception', $e));
    }
    public function doBar(?\ReflectionClass $r)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<object>', $r->name);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<object>|null', $r?->name);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $this->nullableSelf?->self);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $this->nullableSelf?->self->self);
    }
    public function doBaz(?self $self)
    {
        if ($self?->nullableSelf) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Nullsafe\\Foo', $self);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Nullsafe\\Foo', $self->nullableSelf);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Nullsafe\\Foo', $self?->nullableSelf);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self);
            //assertType('null', $self->nullableSelf);
            //assertType('null', $self?->nullableSelf);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self->nullableSelf);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self?->nullableSelf);
    }
    public function doLorem(?self $self)
    {
        if ($self?->nullableSelf !== null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Nullsafe\\Foo', $self);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Nullsafe\\Foo', $self->nullableSelf);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Nullsafe\\Foo', $self?->nullableSelf);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', $self->nullableSelf);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', $self?->nullableSelf);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self->nullableSelf);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self?->nullableSelf);
    }
    public function doIpsum(?self $self)
    {
        if ($self?->nullableSelf === null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', $self->nullableSelf);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', $self?->nullableSelf);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Nullsafe\\Foo', $self);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Nullsafe\\Foo', $self->nullableSelf);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Nullsafe\\Foo', $self?->nullableSelf);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self->nullableSelf);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self?->nullableSelf);
    }
    public function doDolor(?self $self)
    {
        if (!$self?->nullableSelf) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self);
            //assertType('null', $self->nullableSelf);
            //assertType('null', $self?->nullableSelf);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Nullsafe\\Foo', $self);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Nullsafe\\Foo', $self->nullableSelf);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Nullsafe\\Foo', $self?->nullableSelf);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self->nullableSelf);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Nullsafe\\Foo|null', $self?->nullableSelf);
    }
}
