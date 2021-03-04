<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\Utils;

use TenantCloud\BetterReflection\Relocated\Nette;
if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString extends \TenantCloud\BetterReflection\Relocated\Nette\HtmlStringable
    {
    }
} elseif (!\interface_exists(\TenantCloud\BetterReflection\Relocated\Nette\Utils\IHtmlString::class)) {
    \class_alias(\TenantCloud\BetterReflection\Relocated\Nette\HtmlStringable::class, \TenantCloud\BetterReflection\Relocated\Nette\Utils\IHtmlString::class);
}
namespace TenantCloud\BetterReflection\Relocated\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator extends \TenantCloud\BetterReflection\Relocated\Nette\Localization\Translator
    {
    }
} elseif (!\interface_exists(\TenantCloud\BetterReflection\Relocated\Nette\Localization\ITranslator::class)) {
    \class_alias(\TenantCloud\BetterReflection\Relocated\Nette\Localization\Translator::class, \TenantCloud\BetterReflection\Relocated\Nette\Localization\ITranslator::class);
}
