<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3443;

/**
 * Interface Collection.
 */
interface CollectionInterface
{
    /**
     * @param mixed $data
     * @param mixed ...$parameters
     *
     * @return mixed
     */
    public static function with($data = [], ...$parameters);
}
/**
 * Class Collection.
 */
final class Collection implements \TenantCloud\BetterReflection\Relocated\Bug3443\CollectionInterface
{
    public static function with($data = [], ...$parameters)
    {
        return new self();
    }
}
interface TranslatorInterface
{
    /**
     * @param array<int,mixed> $additionalParametersToInjectIntoTranslation
     */
    public function translate(string $translationKey, bool $upperCaseFirst = \true, ...$additionalParametersToInjectIntoTranslation) : string;
}
class Translator implements \TenantCloud\BetterReflection\Relocated\Bug3443\TranslatorInterface
{
    public function translate(string $translationKey, bool $upperCaseFirst = \true, ...$additionalParametersToInjectIntoTranslation) : string
    {
        return 'some fancy translation with possibly some parameters injected';
    }
}
