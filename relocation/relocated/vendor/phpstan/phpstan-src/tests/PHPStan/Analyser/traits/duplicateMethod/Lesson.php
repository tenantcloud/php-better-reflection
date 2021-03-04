<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\DuplicateMethod;

class Lesson
{
    use LessonTrait;
    public function test() : void
    {
        $this->doFoo();
    }
}
