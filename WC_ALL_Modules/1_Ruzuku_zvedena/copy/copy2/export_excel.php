<?php
require 'c:/xampp/vendor/autoload.php'; // Підключення автозавантаження для PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Перевірка методу запиту
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Ваш код підключення до бази даних та вибірки даних

  // Перевірка, чи передані дані у запиті
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

    // Перевірка, чи не порожній $validCodes перед виконанням запиту
    if (!empty($validCodes)) {
      // Підключення файлу з класом і функцією
      $conn = new PDO('odbc:ODBS_dell720', 'rg02', 'rg02');

      $result11 = $conn->query("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");
      $row = $result11->fetch(PDO::FETCH_ASSOC);
      $databaseEncoding = $row['VALUE'];
      echo $databaseEncoding;

      $placeholders = implode(',', array_fill(0, count($validCodes), '?'));
      $query = "SELECT NAME AS CUSTOM_NAME, C_STI_MAIN, TIN, FULL_NAME FROM RG02.R21TAXPAY_u WHERE TIN IN ($placeholders)";
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

      // Встановлення формату для стовпців з даними
      $sheet->getStyle('A1:D' . ($rowIndex - 1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

      // Вивантаження електронної таблиці у файл
      $filename = 'results.xlsx';
      $writer = new Xlsx($spreadsheet);
      $writer->save($filename);

      // Вивантаження файлу
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $filename . '"');
      header('Cache-Control: max-age=0');

      readfile($filename);
      unlink($filename); // Видалення файлу після вивантаження

      // Закриття з'єднання
      $conn = null;
    } else {
      echo "Немає валідних кодів для виконання запиту.";
    }
  } else {
    echo "Дані не передані у запиті.";
  }
}
?>
