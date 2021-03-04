<?php

namespace TenantCloud\BetterReflection\Relocated\PrivatePropertyWithTags;

use TenantCloud\BetterReflection\Relocated\Doctrine\ORM\Mapping as ORM;
class Foo
{
    /**
     * @ORM\Column(type="big_integer", options={"unsigned": true})
     */
    private $title;
    /**
     * @get
     */
    private $text;
    /**
     * @ORM\Column(type="big_integer", options={"unsigned": true})
     * @get
     */
    private $author;
}
