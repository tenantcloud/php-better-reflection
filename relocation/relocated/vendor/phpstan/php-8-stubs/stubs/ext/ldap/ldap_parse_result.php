<?php 

#endif
#ifdef HAVE_LDAP_PARSE_RESULT
/**
 * @param resource $ldap
 * @param resource $result
 * @param int $error_code
 * @param string $matched_dn
 * @param string $error_message
 * @param array $referrals
 * @param array $controls
 */
function ldap_parse_result($ldap, $result, &$error_code, &$matched_dn = null, &$error_message = null, &$referrals = null, &$controls = null) : bool
{
}