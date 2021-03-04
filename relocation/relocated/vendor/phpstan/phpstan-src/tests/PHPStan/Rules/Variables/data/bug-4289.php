<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Bug4289;

class BaseClass
{
    protected $fields = [];
    function populateFields() : void
    {
        $this->fields = ['foo' => 'bar', 'some' => 'what'];
    }
}
class ChildClass extends \TenantCloud\BetterReflection\Relocated\Bug4289\BaseClass
{
    public function populateFields() : void
    {
        if (empty($this->fields)) {
            parent::populateFields();
            unset($this->fields['foo']);
        }
    }
}
