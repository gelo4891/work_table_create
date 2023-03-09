<?php

require_once __DIR__ . '../../WC_2_Class/WC_2_class_all.php';
require_once __DIR__ . '../../WC_2_Class/WC_2_class_auth.php';
require_once __DIR__ . '../../WC_2_config/WC_2_config.php';


/*--------------підключаємося до бази даних----------------- */
$WCA_connect = new WorkClassAll('mysql', $WC_2_config_servername, '3306', $WC_2_config_base_user, $WC_2_config_base_pass, $WC_2_config_base_name, $WC_2_config_table_name);
$WC_class_Auth_connest = new WC_class_Auth('');

//підключення до бази даних
$WC_2_class_all_conn =$WCA_connect->WC_connect_to_base();

if(isset($_POST['WC_username']) && isset($_POST['WC_password'])) {
    $WC_2_start_user = $_POST['WC_username'];
    $WC_2_start_pass = $_POST['WC_password'];  
    $WC_2_Auth_insert_values = array($WC_2_start_user, $WC_2_start_pass);



 $WC_class_Auth_connest->WC_Auth_login_and_update($WC_2_class_all_conn, $WC_2_config_table_name, $WC_2_Auth_insert_values, $WC_2_php_START_AUTH_header);

}

?>
