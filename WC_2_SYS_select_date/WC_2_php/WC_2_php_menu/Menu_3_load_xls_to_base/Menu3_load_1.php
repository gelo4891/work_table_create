<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_config_Path.php');

// Підключаємо необхідні файли і класи
require 'c:/xampp/vendor/autoload.php';
require_once ($WC_2_class_load_XLS);

use PhpOffice\PhpSpreadsheet\IOFactory;

/*----------------------перевіряємо чи підключено клас з бібліотеки-------------------------------------*/

if (class_exists('PhpOffice\PhpSpreadsheet\IOFactory')) {
    if(isset($_FILES['Menu3_load_file'])) {
        $local_file = $_FILES['Menu3_load_file']['tmp_name'];
        $file_name = $_FILES['Menu3_load_file']['name'];
        $content = file_get_contents($local_file);
    // echo $content;
    echo $file_name;
    }
} else {
    echo 'IOFactory class is not available.';
}



// дані для FTP підключення
$ftp_server = "10.6.128.63";
$ftp_port = 21;
$ftp_username = "FZ_Oleg_User";
$ftp_password = "FZ_Oleg_User";

// завантаження файлу на сервер
//$local_file = $_FILES['Menu3_load_file']['tmp_name'];
//$remote_file = $_FILES['Menu3_load_file']['name'];

// встановлення з'єднання та авторизація на сервері FTP
$ftp_conn = ftp_connect($ftp_server, $ftp_port) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_password);

// перевірка з'єднання та завантаження файлу


if ($ftp_conn && $login) {
    if (ftp_put($ftp_conn, $file_name, $local_file, FTP_BINARY)) {
        echo "File transfer successful!";
    } else {
        echo "File transfer failed!";
    }
} else {
    echo "FTP connection has failed!";
}

// закриття з'єднання
ftp_close($ftp_conn);




/*-----------------------Перевіряємо вміст файлу------------------------------------*/

// Ім'я файлу Excel

/*-----------------------------------------------------------*/

// Підключаємося до бази даних
//$conn = new PDO('mysql:host=localhost;dbname=test', 'username', 'password');
$conn = new PDO('odbc:ODBS_dell720','test_c','test_c');

// Створюємо об'єкт класу XlsUploader
$xlsUploader = new XlsUploader($conn);

/*-----------------------------------------------------------*/

/*-----------------------------------------------------------*/

// Ganarete Ім'я таблиці, в яку будемо завантажувати дані

$filename_without_extension = pathinfo($file_name, PATHINFO_FILENAME);
$current_time_1 = date('Ymd_His');
$tablename = 'ole_'.$filename_without_extension . '_' . $current_time_1 ; 

// Створюємо таблицю з полями, що відповідають заголовкам стовпців у файлі Excel
$xlsUploader->createTableFromXls($file_name, $tablename);


$menu_3_path_file = $_SERVER['DOCUMENT_ROOT'] . '/Download_date';

// Завантажуємо дані з файлу Excel в таблицю бази даних
$xlsUploader->uploadXlsToTable($menu_3_path_file,$file_name, $tablename);


?>

