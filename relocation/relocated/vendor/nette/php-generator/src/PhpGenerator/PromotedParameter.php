<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator;

/**
 * Promoted parameter in constructor.
 */
final class PromotedParameter extends \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Parameter
{
    use Traits\VisibilityAware;
    use Traits\CommentAware;
}
