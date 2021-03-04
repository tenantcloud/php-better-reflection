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
final class AnyOf implements \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
{
    use Base;
    use Nette\SmartObject;
    /** @var array */
    private $set;
    /**
     * @param  mixed|Schema  ...$set
     */
    public function __construct(...$set)
    {
        if (!$set) {
            throw new \TenantCloud\BetterReflection\Relocated\Nette\InvalidStateException('The enumeration must not be empty.');
        }
        $this->set = $set;
    }
    public function firstIsDefault() : self
    {
        $this->default = $this->set[0];
        return $this;
    }
    public function nullable() : self
    {
        $this->set[] = null;
        return $this;
    }
    public function dynamic() : self
    {
        $this->set[] = new \TenantCloud\BetterReflection\Relocated\Nette\Schema\Elements\Type(\TenantCloud\BetterReflection\Relocated\Nette\Schema\DynamicParameter::class);
        return $this;
    }
    /********************* processing ****************d*g**/
    public function normalize($value, \TenantCloud\BetterReflection\Relocated\Nette\Schema\Context $context)
    {
        return $this->doNormalize($value, $context);
    }
    public function merge($value, $base)
    {
        if (\is_array($value) && isset($value[\TenantCloud\BetterReflection\Relocated\Nette\Schema\Helpers::PREVENT_MERGING])) {
            unset($value[\TenantCloud\BetterReflection\Relocated\Nette\Schema\Helpers::PREVENT_MERGING]);
            return $value;
        }
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Helpers::merge($value, $base);
    }
    public function complete($value, \TenantCloud\BetterReflection\Relocated\Nette\Schema\Context $context)
    {
        $expecteds = $innerErrors = [];
        foreach ($this->set as $item) {
            if ($item instanceof \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema) {
                $dolly = new \TenantCloud\BetterReflection\Relocated\Nette\Schema\Context();
                $dolly->path = $context->path;
                $res = $item->complete($item->normalize($value, $dolly), $dolly);
                if (!$dolly->errors) {
                    $context->warnings = \array_merge($context->warnings, $dolly->warnings);
                    return $this->doFinalize($res, $context);
                }
                foreach ($dolly->errors as $error) {
                    if ($error->path !== $context->path || empty($error->variables['expected'])) {
                        $innerErrors[] = $error;
                    } else {
                        $expecteds[] = $error->variables['expected'];
                    }
                }
            } else {
                if ($item === $value) {
                    return $this->doFinalize($value, $context);
                }
                $expecteds[] = \TenantCloud\BetterReflection\Relocated\Nette\Schema\Helpers::formatValue($item);
            }
        }
        if ($innerErrors) {
            $context->errors = \array_merge($context->errors, $innerErrors);
        } else {
            $context->addError('The %label% %path% expects to be %expected%, %value% given.', \TenantCloud\BetterReflection\Relocated\Nette\Schema\Message::TYPE_MISMATCH, ['value' => $value, 'expected' => \implode('|', \array_unique($expecteds))]);
        }
    }
    public function completeDefault(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Context $context)
    {
        if ($this->required) {
            $context->addError('The mandatory item %path% is missing.', \TenantCloud\BetterReflection\Relocated\Nette\Schema\Message::MISSING_ITEM);
            return null;
        }
        if ($this->default instanceof \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema) {
            return $this->default->completeDefault($context);
        }
        return $this->default;
    }
}
