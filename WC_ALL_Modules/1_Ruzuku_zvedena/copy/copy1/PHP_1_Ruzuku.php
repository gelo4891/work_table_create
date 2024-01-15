<?php
/*=============================================================*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $codes = $_POST['codes'];
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
?>

<div id="table-good">
  <table>
    <thead>
      <tr>
        <th>Валідні коди</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($validCodes as $code): ?>
        <tr>
          <td><?php echo $code; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div id="table-error">
  <table>
    <thead>
      <tr>
        <th>Помилкові коди</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($errorCodes as $code): ?>
        <tr>
          <td><?php echo $code; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php 
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

    ?>

    <div id="table-data">
      <table>
        <thead>
          <tr>
            <th>name</th>
            <th>C_STI_MAIN</th>
            <th>TIN</th>
            <th>FULL_NAME</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $stmt_test_c->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
              <td><?php echo iconv('WINDOWS-1251', 'UTF-8', $row['CUSTOM_NAME']); ?></td>
              <td><?php echo iconv('WINDOWS-1251', 'UTF-8', $row['C_STI_MAIN']); ?></td>
              <td><?php echo iconv('WINDOWS-1251', 'UTF-8', $row['TIN']); ?></td>
              <td><?php echo iconv('WINDOWS-1251', 'UTF-8', $row['FULL_NAME']); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <?php
    // Закриття з'єднання
    $conn = null;
  } else {
    echo "Немає валідних кодів для виконання запиту.";
  }
?>

<?php
}
?>
