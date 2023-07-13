<?php
/*=============================перевірка сесії======================================== */
    require_once ($_SERVER['DOCUMENT_ROOT'] .'/session/WC_2_check_sesion.php');
    $session_check = new SessionChecker();

    // Реєструємо обробник помилок

    set_error_handler(array($session_check, "session_errorHandler"));
   
    //перевірка сесії
    $chek_auh=$session_check->WC_Auth_check_session(false,'/WC_2_SYS_select_date/WC_2_start.php');

/**===================================================================== */

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
    $WC_2_class_all=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_class_all');
    $WC_2_CSS_all=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_CSS_all');
    $SQL_create_menu=$WCA_connect->WC_CL_conn_query_sql($WC_conn, 'SQL_create_menu');
    $WC_2_CSS_menu_create=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_CSS_menu_create');
    $Menu_3_load_xls_to_base_1=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$Menu_3_load_xls_to_base_1');
    $WC_2_class_load_XLS=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_class_load_XLS');
    $Bibl_composer=$WCA_connect->WC_CL_conn_query_sql($WC_conn, 'Bibl_composer');
    $WC_2_config_MySql_table_name=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_config_MySql_table_name');
    $WC_2_config_MySql_tname_menu=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_config_MySql_tname_menu');
    $WC_2_config_table_colum=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_config_table_colum');
    $WC_2_menu_create=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_menu_create');
/*==============================підключення параметрів з БАЗИ ORACLE====================*/
    $dell720_ODBC=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$dell720_ODBC');
    $dell720_test_c_user=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$dell720_test_c_user');
    $dell720_test_c_pass=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$dell720_test_c_pass');

/*==============================дані для FTP підключення====================*/
    $ftp_server=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$ftp_server');
    $ftp_port=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$ftp_port');
    $ftp_username=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$ftp_username');
    $ftp_password=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$ftp_password');

/*===========================================================================================================*/
    require_once ($WC_2_class_auth);
    require_once ($WC_2_class_all);
    require_once ($WC_2_class_load_XLS);
    require ($Bibl_composer);
/*===========================================================================================================*/
    

    ?>