<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Tests;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Finder;
class ClassThatInheritFinder extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Finder
{
    /**
     * @return $this
     */
    public function sortByName()
    {
        parent::sortByName();
    }
}
