<?php

//require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_config_Path.php');

// Підключаємо необхідні файли і класи
//require 'c:/xampp/vendor/autoload.php';
//require_once ($WC_2_class_load_XLS);


/*=============================================підключення параметрів з БАЗИ==============================================================*/
require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_config_BAse.php');
require_once ($WC_2_config_base_CL);

$WCA_connect = new WC_CL_Conn_Base(); 
$WC_conn = $WCA_connect->WC_CL_conn_base_func();    

$WC_2_class_auth=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_class_auth');
$WC_2_class_load_XLS=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_class_load_XLS');
$Bibl_composer=$WCA_connect->WC_CL_conn_query_sql($WC_conn, 'Bibl_composer');
$WC_2_class_all=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_class_all');


$dell720_ODBC=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$dell720_ODBC');
$dell720_test_c_user=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$dell720_test_c_user');
$dell720_test_c_pass=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$dell720_test_c_pass');

// дані для FTP підключення
$ftp_server=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$ftp_server');
$ftp_port=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$ftp_port');
$ftp_username=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$ftp_username');
$ftp_password=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$ftp_password');

require_once ($WC_2_class_auth);
require_once ($WC_2_class_load_XLS);
require_once ($WC_2_class_all);
require ($Bibl_composer);

/*===========================================================================================================*/
  $WCA_WorkClassAll = new WorkClassAll();
  WorkClassAll::WC_2_JS_PutToDiv1('WC_2_menu_create_Menu','WC_2_menu_create_content' );

use PhpOffice\PhpSpreadsheet\IOFactory;

/*----------------------перевіряємо чи підключено клас з бібліотеки-------------------------------------*/

if (class_exists('PhpOffice\PhpSpreadsheet\IOFactory')) {
    if(isset($_FILES['Menu3_load_file'])) {
  // завантаження файлу на сервер    

       $local_file = $_FILES['Menu3_load_file']['tmp_name'];
       $file_name = $_FILES['Menu3_load_file']['name'];
       $content = file_get_contents($local_file);

// встановлення з'єднання та авторизація на сервері FTP
$ftp_conn = ftp_connect($ftp_server, $ftp_port) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_password);

// перевірка з'єднання та завантаження файлу

if ($ftp_conn && $login) {
    if (ftp_put($ftp_conn, $file_name, $local_file, FTP_BINARY)) {
        echo "File transfer successful!";   
   
   /*-----------------------------------------------------------*/
// Підключаємося до бази даних
$conn = new PDO("odbc:$dell720_ODBC","$dell720_test_c_user","$dell720_test_c_pass");


/*$conn = new PDO('odbc:ODBS_dell720','test_c','test_c');
>>>>>>> Stashed changes
*/
// Створюємо об'єкт класу XlsUploader
$xlsUploader = new XlsUploader($conn);
// Ganarete Ім'я таблиці, в яку будемо завантажувати дані

$filename_without_extension = pathinfo($file_name, PATHINFO_FILENAME);
$current_time_1 = date('Ymd_His');
$tablename = 'ole_'.$filename_without_extension . '_' . $current_time_1 ; 

/*-----------------------------------------------------------*/



/*-----------------------------------------------------------*/

// Ім'я таблиці, в яку будемо завантажувати дані


// Створюємо таблицю з полями, що відповідають заголовкам стовпців у файлі Excel

$menu_3_path_file = $_SERVER['DOCUMENT_ROOT'] . '/Download_date';

/*---------------------------окремо дві функції
------------------------------------створення таблиці ------------------------------
$xlsUploader->createTableFromXls($menu_3_path_file,$file_name, $tablename);
------------------------------------завантаження даних ------------------------------
// Завантажуємо дані з файлу Excel в таблицю бази даних
$xlsUploader->uploadXlsToTable($menu_3_path_file,$file_name, $tablename);
  */ 
    try {
      //  print_r($_SESSION);

       $xlsUploader->CreateImportDataFromXls($menu_3_path_file,$file_name, $tablename,'0');
    } catch (\Exception $e) {
     echo "Error: " . $e->getMessage();
    }

     } else {
        echo "File transfer failed!";
    }
} else {
    echo "FTP connection has failed!";
}

// закриття з'єднання
ftp_close($ftp_conn);


////$xlsUploader->uploadXlsToTable($filename, $tablename);


}
} else {
    echo 'IOFactory class is not available.';
}
?>

