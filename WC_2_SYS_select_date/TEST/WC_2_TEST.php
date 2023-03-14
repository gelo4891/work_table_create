<?php
require_once __DIR__ . '../../WC_2_Class/WC_2_class_auth.php';


$WC_class_Auth_connest = new WC_class_Auth('');

$WC_class_Auth_connest->WC_Auth_check_session('../../index.php', false, 'You are not logged in. Please log in to continue.');


echo 'test';



?>