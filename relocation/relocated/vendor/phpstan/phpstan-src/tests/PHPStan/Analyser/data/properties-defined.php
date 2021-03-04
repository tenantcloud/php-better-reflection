<?php

namespace TenantCloud\BetterReflection\Relocated\PropertiesNamespace;

use DOMDocument;
use TenantCloud\BetterReflection\Relocated\SomeNamespace\Sit as Dolor;
/**
 * @property-read int $readOnlyProperty
 * @property-read int $overriddenReadOnlyProperty
 */
class Bar extends \DOMDocument
{
    /**
     * @var Dolor
     */
    protected $inheritedProperty;
    /**
     * @var self
     */
    protected $inheritDocProperty;
    /**
     * @var self
     */
    protected $inheritDocWithoutCurlyBracesProperty;
    /**
     * @var self
     */
    protected $implicitInheritDocProperty;
    public function doBar() : \TenantCloud\BetterReflection\Relocated\PropertiesNamespace\Self
    {
    }
}
