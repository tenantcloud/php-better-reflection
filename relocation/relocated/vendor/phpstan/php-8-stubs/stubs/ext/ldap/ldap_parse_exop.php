<?php 

#endif
#ifdef HAVE_LDAP_PARSE_EXTENDED_RESULT
/**
 * @param resource $ldap
 * @param resource $result
 * @param string $response_data
 * @param string $response_oid
 */
function ldap_parse_exop($ldap, $result, &$response_data = null, &$response_oid = null) : bool
{
}