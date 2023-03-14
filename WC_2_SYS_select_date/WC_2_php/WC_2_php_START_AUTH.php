<?php

require_once __DIR__ . '../../WC_2_Class/WC_2_class_all.php';
require_once __DIR__ . '../../WC_2_Class/WC_2_class_auth.php';
require_once __DIR__ . '../../WC_2_config/WC_2_config.php';


/*--------------підключаємося до бази даних----------------- */

try {
    $WCA_connect = new WorkClassAll('mysql', $WC_2_config_MySql_servername, $WC_2_config_MySql_port, $WC_2_config_MySql_base_user, $WC_2_config_MySql_base_pass, $WC_2_config_MySql_base_name, $WC_2_config_MySql_table_name);
   // $WCA_connect = new WorkClassAll('oracle', $WC_2_config_servername, $WC_2_config_port, $WC_2_config_base_user, $WC_2_config_base_pass, $WC_2_config_base_name, $WC_2_config_table_name);
    $conn = $WCA_connect->WC_connect_to_base_PDO();
    if (!$conn) {
      echo die("Failed to connect to database");
    }
        // Тут виконуємо запити до бази даних
    if ($conn){
        $WC_class_Auth_connest = new WC_class_Auth('');
        if(isset($_POST['WC_username']) && isset($_POST['WC_password'])) {
          $WC_2_start_login = $_POST['WC_username'];
          $WC_2_start_pass  = $_POST['WC_password'];  
         // $WC_class_Auth_connest->WC_Auth_login_and_update_PDO($conn, $WC_2_start_login, $WC_2_start_pass, $WC_2_config_table_name, $WC_2_config_table_colum, $WC_2_php_START_AUTH_header);
         $WC_class_Auth_connest->WC_Auth_login_and_update_PDO_universal($conn, $WC_2_start_login, $WC_2_start_pass, $WC_2_config_MySql_table_name, $WC_2_config_table_colum, $WC_2_php_START_AUTH_header);
        }
    }
    else {
        echo $WC_class_Auth_connest;
    }

    $WCA_connect->WC_disconnect_from_base();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

?>
