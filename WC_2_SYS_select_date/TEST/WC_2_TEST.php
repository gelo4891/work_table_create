<?php
require_once __DIR__ . '../../WC_2_Class/WC_2_class_auth.php';


$WC_class_Auth_connest = new WC_class_Auth('');

$session_reliable=$WC_class_Auth_connest->check_session();

if (!$session_reliable) {
    ECHO ('file WC_2_TEST.php  connectedDDDDDDDDDDDDDDDDDDD');
 
} else {
    ECHO ('file WC_2_TEST.php  NOTTTTTTTTTTTTTTTT connected');
}






?>