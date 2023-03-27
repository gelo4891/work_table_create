<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_config_Path.php');

// Підключаємо необхідні файли і класи
require 'o:/xampp/vendor/autoload.php';
require_once ($WC_2_class_load_XLS);

use PhpOffice\PhpSpreadsheet\IOFactory;

/*----------------------перевіряємо чи пвідключено клас з бібліотеки-------------------------------------*/


if (class_exists('PhpOffice\PhpSpreadsheet\IOFactory')) {
    if(isset($_FILES['Menu3_load_file'])) {
        $file = $_FILES['Menu3_load_file']['tmp_name'];
        $file_name = $_FILES['Menu3_load_file']['name'];
        $content = file_get_contents($file);
    // echo $content;
    echo $file_name;
    }
} else {
    echo 'IOFactory class is not available.';
}


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

// Ім'я таблиці, в яку будемо завантажувати дані
$tablename = 'students';

// Створюємо таблицю з полями, що відповідають заголовкам стовпців у файлі Excel
$xlsUploader->createTableFromXls($filename, $tablename);

// Завантажуємо дані з файлу Excel в таблицю бази даних
$xlsUploader->uploadXlsToTable($filename, $tablename);


?>

