<?php 

#ifdef HAVE_FTP_SSL
/** @return resource|false */
function ftp_ssl_connect(string $hostname, int $port = 21, int $timeout = 90)
{
}