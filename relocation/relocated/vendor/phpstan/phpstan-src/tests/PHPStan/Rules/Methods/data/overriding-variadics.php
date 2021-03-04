<?php

namespace TenantCloud\BetterReflection\Relocated\OverridingVariadics;

interface ITranslator
{
    /**
     * Translates the given string.
     * @param  mixed  $message
     * @param  string  ...$parameters
     */
    function translate($message, string ...$parameters) : string;
}
class Translator implements \TenantCloud\BetterReflection\Relocated\OverridingVariadics\ITranslator
{
    /**
     * @param string $message
     * @param string ...$parameters
     */
    public function translate($message, $lang = 'cs', string ...$parameters) : string
    {
    }
}
class OtherTranslator implements \TenantCloud\BetterReflection\Relocated\OverridingVariadics\ITranslator
{
    public function translate($message, $lang, string ...$parameters) : string
    {
    }
}
class AnotherTranslator implements \TenantCloud\BetterReflection\Relocated\OverridingVariadics\ITranslator
{
    public function translate($message, $lang = 'cs', string $parameters) : string
    {
    }
}
class YetAnotherTranslator implements \TenantCloud\BetterReflection\Relocated\OverridingVariadics\ITranslator
{
    public function translate($message, $lang = 'cs') : string
    {
    }
}
class ReflectionClass extends \ReflectionClass
{
    public function newInstance($arg = null, ...$args)
    {
    }
}
