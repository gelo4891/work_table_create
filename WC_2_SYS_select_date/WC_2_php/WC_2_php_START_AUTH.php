  <?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_config_Auth.php');

    echo "<link  type='text/css'  rel='stylesheet' href='$WC_2_CSS_all'>";

    try {
        if (!$WC_conn) {
          echo die("Failed to connect to database");
        }
            // Тут виконуємо запити до бази даних

        if ($WC_conn){
            $WC_class_Auth_connest = new WC_class_Auth('');
            if(isset($_POST['WC_username']) && isset($_POST['WC_password'])) {
              $WC_2_start_login = $_POST['WC_username'];
              $WC_2_start_pass  = $_POST['WC_password'];           
              $WC_class_Auth_connest->WC_Auth_login_and_update_PDO_universal_hash($WC_conn, $WC_2_start_login, $WC_2_start_pass, $WC_2_config_MySql_table_name, $WC_2_config_table_colum, $WC_2_menu_create);
            }
        }
        else {
            echo $WC_class_Auth_connest;
        }

       $WCA_connect->WC_CL_conn_disconnect_from_base();
    } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

?>
