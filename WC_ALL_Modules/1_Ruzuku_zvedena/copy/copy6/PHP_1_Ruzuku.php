<?php
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

<div id="table-good">
  <table>
    <thead>
      <tr>
      <th colspan="<?php echo count($validCodes); ?>">Правильні коди</th>
      </tr>
    </thead>
    <tbody>
    <tr>
      <?php foreach ($validCodes as $code): ?>
          <td><?php echo $code; ?></td>
      <?php endforeach; ?>
      </tr>
    </tbody>
  </table>
</div>

<div id="table-error">
  <table>
    <thead>
      <tr>
      <th colspan="<?php echo count($errorCodes); ?>">Помилкові коди</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php foreach ($errorCodes as $code): ?> 
       <td><?php echo $code; ?></td>      
      <?php endforeach; ?>
      </tr>
    </tbody>
  </table>
</div>

<?php 
  if (!empty($validCodes)) {
    // Підключення до бази даних
    $conn = new PDO('odbc:ODBS_dell720', 'rg02', 'rg02');

    $placeholders = implode(',', array_fill(0, count($validCodes), '?'));
    $query = "SELECT NAME AS CUSTOM_NAME, C_STI_MAIN, TIN, FULL_NAME FROM RG02.R21TAXPAY WHERE TIN IN ($placeholders)";
    $stmt_test_c = $conn->prepare($query);
    $stmt_test_c->execute($validCodes);

    // Виведення даних у таблиці
    echo '<div id="table-data"><table><thead><tr><th>name</th><th>C_STI_MAIN</th><th>TIN</th><th>FULL_NAME</th></tr></thead><tbody>';
    while ($row = $stmt_test_c->fetch(PDO::FETCH_ASSOC)) {
      echo '<tr>';
      echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['CUSTOM_NAME']) . '</td>';
      echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['C_STI_MAIN']) . '</td>';
      echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['TIN']) . '</td>';
      echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row['FULL_NAME']) . '</td>';
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
