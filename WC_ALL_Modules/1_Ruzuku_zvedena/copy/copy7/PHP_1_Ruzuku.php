<?php
/*
 1. виносимо налаштування в config;
 2. запит в окремий файл; 
  
 */

 require_once 'conf_1_Ruzuku/conf_1_Ruzuku.php';
 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $codes = $_POST['codes'];
  $codeArray = preg_split('/[;\r\n\,]+/', $codes);
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
    
?>

<?php if (!empty($validCodes)): ?>
  <div id="table-good">
    <table>
      <thead>
        <tr>
          <th colspan="<?php echo count($validCodes); ?>">Правильні коди</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <?php foreach ($validCodes as $code): ?>
              <?php echo $code.';'; ?>
            <?php endforeach; ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php if (!empty($errorCodes)): ?>
  <div id="table-error">
    <table>
      <thead>
        <tr>
          <th colspan="<?php echo count($errorCodes); ?>">Помилкові коди</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <?php foreach ($errorCodes as $code): ?> 
              <?php echo $code.';'; ?>      
            <?php endforeach; ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php 
  if (!empty($validCodes)) {
    // Підключення до бази даних
   // $conn = new PDO('odbc:ODBS_dell720', 'rg02', 'rg02');
    $conn = new PDO($dbDsn, $dbUser, $dbPass);
/*
    $placeholders = implode(',', array_fill(0, count($validCodes), '?'));
    
    //$query_SQL = "SELECT NAME AS CUSTOM_NAME, C_STI_MAIN, TIN, FULL_NAME FROM RG02.R21TAXPAY WHERE TIN IN ($placeholders)";
    $query_SQL = getQuerySQL($placeholders); // Викликаємо функцію для отримання SQL запиту
   // $query_SQL = getQuerySQL(); // Викликаємо функцію для отримання SQL запиту
    $stmt_test_c = $conn->prepare($query_SQL);
    $stmt_test_c->execute($validCodes);
*/
     // Підготовлюємо запит
    $query_SQL = getQuerySQL(count($validCodes));
    $stmt_test_c = $conn->prepare($query_SQL);

    // Виконуємо запит, передаючи масив $validCodes
    $stmt_test_c->execute($validCodes);

    // Отримуємо інформацію про стовпці з результату запиту
    $columns = [];
    for ($i = 0; $i < $stmt_test_c->columnCount(); $i++) {
        $colMeta = $stmt_test_c->getColumnMeta($i);
        $columns[] = $colMeta['name'];
    }

// Виводимо інформацію про стовпці
var_dump($columns);



    // Виведення даних у таблиці
    echo '<div id="table-data"><table><thead><tr><th>tin</th><th>name</th><th>m1</th><th>avgz_m1</th><th>m2</th><th>avgz_m2</th><th>m3</th><th>avgz_m3</th><th>spl_vsogo</th><th>spl_pdv</th><th>BVOZnapoch</th><th>BVOZnakin</th><th>obsjag</th><th>nav</th><th>r18</th><th>r19</th><th>zag_plosha</th></tr></thead><tbody>';

    while ($row = $stmt_test_c->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['TIN']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['NAME']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['M1']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['AVGZ_M1']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['M2']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['AVGZ_M2']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['M3']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['AVGZ_M3']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['SPL_VSOGO']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['SPL_PDV']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['BVOZNAPOCH']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['BVOZNAKIN']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['OBSJAG']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['NAV']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['R18']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['R19']) . '</td>';
    echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['ZAG_PLOSHA']) . '</td>';
    echo '</tr>';
}

    
    echo '</tbody></table></div>';
    

    // Закриття з'єднання
    $conn = null;
  } else {
    echo "Немає валідних кодів для виконання запиту.";
  }
}
?>
