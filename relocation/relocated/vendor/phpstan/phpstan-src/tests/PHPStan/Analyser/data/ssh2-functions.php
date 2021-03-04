<?php

namespace TenantCloud\BetterReflection\Relocated;

/** @var resource $resource */
$resource = \TenantCloud\BetterReflection\Relocated\doFoo();
$ssh2SftpStat = \ssh2_sftp_stat($resource, __FILE__);
die;
