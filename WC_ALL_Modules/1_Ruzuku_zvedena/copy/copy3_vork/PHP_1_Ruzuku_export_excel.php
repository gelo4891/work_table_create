<?php
require 'c:/xampp/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Підключення до бази даних
  $conn = new PDO('odbc:ODBS_dell720', 'rg02', 'rg02');

  // Отримання кодів з запиту GET
  if (isset($_GET['codes'])) {
    $codes = $_GET['codes'];
    $codeArray = preg_split('/[;\r\n]+/', $codes);
    $validCodes = [];
    $errorCodes = [];

    foreach ($codeArray as $code) {
      $code = trim($code);
      if (is_numeric($code) && strlen($code) <= 10) {
        $validCodes[] = $code;
      } else {
        $errorCodes[] = $code;
      }
    }

    if (!empty($validCodes)) {
      $placeholders = implode(',', array_fill(0, count($validCodes), '?'));
      $query = "SELECT NAME AS CUSTOM_NAME, C_STI_MAIN, TIN, FULL_NAME FROM RG02.R21TAXPAY WHERE TIN IN ($placeholders)";
      $stmt_test_c = $conn->prepare($query);
      $stmt_test_c->execute($validCodes);

      // Створення нового об'єкту Spreadsheet
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();

      // Встановлення заголовків стовпців
      $sheet->setCellValue('A1', 'name');
      $sheet->setCellValue('B1', 'C_STI_MAIN');
      $sheet->setCellValue('C1', 'TIN');
      $sheet->setCellValue('D1', 'FULL_NAME');

      // Запис даних з результатів запиту у комірки електронної таблиці
      $rowIndex = 2;
      while ($row = $stmt_test_c->fetch(PDO::FETCH_ASSOC)) {
        $sheet->setCellValue('A' . $rowIndex, iconv('WINDOWS-1251', 'UTF-8', $row['CUSTOM_NAME']));
        $sheet->setCellValue('B' . $rowIndex, iconv('WINDOWS-1251', 'UTF-8', $row['C_STI_MAIN']));
        $sheet->setCellValue('C' . $rowIndex, iconv('WINDOWS-1251', 'UTF-8', $row['TIN']));
        $sheet->setCellValue('D' . $rowIndex, iconv('WINDOWS-1251', 'UTF-8', $row['FULL_NAME']));
        $rowIndex++;
      }

      // Збереження електронної таблиці у файл
      $writer = new Xlsx($spreadsheet);
      $filename = 'results.xlsx';
      $writer->save($filename);

      // Виведення посилання на завантаження файлу
      echo '<div id="export-link"><a href="' . $filename . '">Завантажити Excel</a></div>';
    } else {
      echo "Немає валідних кодів для виконання запиту.";
    }
  } else {
    echo "Дані не передані у запиті.";
  }

  // Закриття з'єднання
  $conn = null;
}
?>
