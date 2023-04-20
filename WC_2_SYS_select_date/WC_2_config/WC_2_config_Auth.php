<?php
/*=============================перевірка сесії======================================== */
    require_once ($_SERVER['DOCUMENT_ROOT'] .'/session/WC_2_check_sesion.php');
    $session_check = new SessionChecker();

    // Реєструємо обробник помилок

    set_error_handler(array($session_check, "session_errorHandler"));
/*===================================================================== */

/*=============================================підключення параметрів з БАЗИ==============================================================*/
    $WC_2_config_MySql_servername = "localhost";
    $WC_2_config_MySql_port = "3306";
    $WC_2_config_MySql_base_name = "base_o_zvit";
    $WC_2_config_MySql_base_user = "gelo4891";
    $WC_2_config_MySql_base_pass = "gelo1111";
/*=================================підключення класу вибірки даних з бази==================================== */
    $WC_2_config_base_CL  = $_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_Class/WC_2_CL_Conn_Base.php'; 
    require_once ($WC_2_config_base_CL);
  
/*=================================отримання параметрів з бази ==================================== */
    $WCA_connect = new WC_CL_Conn_Base(); 
    $WC_conn = $WCA_connect->WC_CL_conn_base_func();    

    $WC_2_class_auth=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_class_auth');
    $WC_2_CSS_all=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_CSS_all');
    $WC_2_config_MySql_table_name=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_config_MySql_table_name');
    $WC_2_config_MySql_tname_menu=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_config_MySql_tname_menu');
    $WC_2_config_table_colum=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_config_table_colum');
    $WC_2_menu_create=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_menu_create');

    require_once ($WC_2_class_auth);

    

    ?>