<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\ConstFile;

const TABLE_NAME = 'resized_images';
\define('ANOTHER_NAME', 'foo_images');
\define('TenantCloud\\BetterReflection\\Relocated\\ConstFile\\ANOTHER_NAME', 'bar_images');
\define('TEST_VARIABLE', $foo);
\define('const_with_dir_const', __DIR__);
