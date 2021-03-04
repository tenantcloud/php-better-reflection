<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\DuplicateMethod;

trait LessonTrait
{
    use LessonSubtraitOne;
    use LessonSubtraitTwo;
}
