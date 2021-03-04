<?php

namespace TenantCloud\BetterReflection\Relocated\TypeInCommentOnForeach;

/** @var mixed[] $values */
$values = [];
/** @var string $value */
foreach ($values as &$value) {
    die;
}
