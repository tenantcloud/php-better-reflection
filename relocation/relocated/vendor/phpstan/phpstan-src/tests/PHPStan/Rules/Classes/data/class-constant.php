<?php

namespace TenantCloud\BetterReflection\Relocated\ClassConstantNamespace;

\TenantCloud\BetterReflection\Relocated\ClassConstantNamespace\Foo::class;
\TenantCloud\BetterReflection\Relocated\ClassConstantNamespace\Bar::class;
self::class;
\TenantCloud\BetterReflection\Relocated\ClassConstantNamespace\Foo::LOREM;
\TenantCloud\BetterReflection\Relocated\ClassConstantNamespace\Foo::IPSUM;
\TenantCloud\BetterReflection\Relocated\ClassConstantNamespace\Foo::DOLOR;
$bar::LOREM;
$foo = new \TenantCloud\BetterReflection\Relocated\ClassConstantNamespace\Foo();
$foo::LOREM;
$foo::IPSUM;
$foo::DOLOR;
static::LOREM;
parent::LOREM;
\TenantCloud\BetterReflection\Relocated\ClassConstantNamespace\UnknownClass::FOO;
$string = 'str';
$string::FOO;
\TenantCloud\BetterReflection\Relocated\ClassConstantNamespace\FOO::class;
\TenantCloud\BetterReflection\Relocated\ClassConstantNamespace\FOO::DOLOR;
\TenantCloud\BetterReflection\Relocated\ClassConstantNamespace\FOO::LOREM;
/** @var Foo|string $fooOrString */
$fooOrString = doFoo();
$fooOrString::LOREM;
$fooOrString::DOLOR;
