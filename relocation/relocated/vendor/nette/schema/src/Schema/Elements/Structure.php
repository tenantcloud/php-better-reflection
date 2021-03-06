<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\Schema\Elements;

use TenantCloud\BetterReflection\Relocated\Nette;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Context;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Helpers;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema;
final class Structure implements \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
{
    use Base;
    use Nette\SmartObject;
    /** @var Schema[] */
    private $items;
    /** @var Schema|null  for array|list */
    private $otherItems;
    /** @var array{?int, ?int} */
    private $range = [null, null];
    /** @var bool */
    private $skipDefaults = \false;
    /**
     * @param  Schema[]  $items
     */
    public function __construct(array $items)
    {
        (function (\TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema ...$items) {
        })(...\array_values($items));
        $this->items = $items;
        $this->castTo = 'object';
        $this->required = \true;
    }
    public function default($value) : self
    {
        throw new \TenantCloud\BetterReflection\Relocated\Nette\InvalidStateException('Structure cannot have default value.');
    }
    public function min(?int $min) : self
    {
        $this->range[0] = $min;
        return $this;
    }
    public function max(?int $max) : self
    {
        $this->range[1] = $max;
        return $this;
    }
    /**
     * @param  string|Schema  $type
     */
    public function otherItems($type = 'mixed') : self
    {
        $this->otherItems = $type instanceof \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema ? $type : new \TenantCloud\BetterReflection\Relocated\Nette\Schema\Elements\Type($type);
        return $this;
    }
    public function skipDefaults(bool $state = \true) : self
    {
        $this->skipDefaults = $state;
        return $this;
    }
    /********************* processing ****************d*g**/
    public function normalize($value, \TenantCloud\BetterReflection\Relocated\Nette\Schema\Context $context)
    {
        if ($prevent = \is_array($value) && isset($value[\TenantCloud\BetterReflection\Relocated\Nette\Schema\Helpers::PREVENT_MERGING])) {
            unset($value[\TenantCloud\BetterReflection\Relocated\Nette\Schema\Helpers::PREVENT_MERGING]);
        }
        $value = $this->doNormalize($value, $context);
        if (\is_object($value)) {
            $value = (array) $value;
        }
        if (\is_array($value)) {
            foreach ($value as $key => $val) {
                $itemSchema = $this->items[$key] ?? $this->otherItems;
                if ($itemSchema) {
                    $context->path[] = $key;
                    $value[$key] = $itemSchema->normalize($val, $context);
                    \array_pop($context->path);
                }
            }
            if ($prevent) {
                $value[\TenantCloud\BetterReflection\Relocated\Nette\Schema\Helpers::PREVENT_MERGING] = \true;
            }
        }
        return $value;
    }
    public function merge($value, $base)
    {
        if (\is_array($value) && isset($value[\TenantCloud\BetterReflection\Relocated\Nette\Schema\Helpers::PREVENT_MERGING])) {
            unset($value[\TenantCloud\BetterReflection\Relocated\Nette\Schema\Helpers::PREVENT_MERGING]);
            $base = null;
        }
        if (\is_array($value) && \is_array($base)) {
            $index = 0;
            foreach ($value as $key => $val) {
                if ($key === $index) {
                    $base[] = $val;
                    $index++;
                } elseif (\array_key_exists($key, $base)) {
                    $itemSchema = $this->items[$key] ?? $this->otherItems;
                    $base[$key] = $itemSchema ? $itemSchema->merge($val, $base[$key]) : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Helpers::merge($val, $base[$key]);
                } else {
                    $base[$key] = $val;
                }
            }
            return $base;
        }
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Helpers::merge($value, $base);
    }
    public function complete($value, \TenantCloud\BetterReflection\Relocated\Nette\Schema\Context $context)
    {
        if ($value === null) {
            $value = [];
            // is unable to distinguish null from array in NEON
        }
        $this->doDeprecation($context);
        if (!$this->doValidate($value, 'array', $context) || !$this->doValidateRange($value, $this->range, $context)) {
            return;
        }
        $errCount = \count($context->errors);
        $items = $this->items;
        if ($extraKeys = \array_keys(\array_diff_key($value, $items))) {
            if ($this->otherItems) {
                $items += \array_fill_keys($extraKeys, $this->otherItems);
            } else {
                $keys = \array_map('strval', \array_keys($items));
                foreach ($extraKeys as $key) {
                    $hint = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Helpers::getSuggestion($keys, (string) $key);
                    $context->addError('Unexpected item %path%' . ($hint ? ", did you mean '%hint%'?" : '.'), \TenantCloud\BetterReflection\Relocated\Nette\Schema\Message::UNEXPECTED_ITEM, ['hint' => $hint])->path[] = $key;
                }
            }
        }
        foreach ($items as $itemKey => $itemVal) {
            $context->path[] = $itemKey;
            if (\array_key_exists($itemKey, $value)) {
                $value[$itemKey] = $itemVal->complete($value[$itemKey], $context);
            } else {
                $default = $itemVal->completeDefault($context);
                // checks required item
                if (!$context->skipDefaults && !$this->skipDefaults) {
                    $value[$itemKey] = $default;
                }
            }
            \array_pop($context->path);
        }
        if (\count($context->errors) > $errCount) {
            return;
        }
        return $this->doFinalize($value, $context);
    }
    public function completeDefault(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Context $context)
    {
        return $this->required ? $this->complete([], $context) : null;
    }
}
