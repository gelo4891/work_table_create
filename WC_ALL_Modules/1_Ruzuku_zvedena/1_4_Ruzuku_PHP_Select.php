<?php
/*==============================перевірка сесії====================================== */
require_once ($_SERVER['DOCUMENT_ROOT'] .'/session/WC_2_check_sesion.php');
$session_checker1 = new SessionChecker();
$chek_auh=$session_checker1->WC_Auth_check_session(false,'/WC_2_SYS_select_date/WC_2_start.php');

/**===================================================================== */

 //require_once 'conf_1_Ruzuku/conf_1_Ruzuku.php';
 require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_ALL_Modules/1_Ruzuku_zvedena/conf_1_Ruzuku/conf_1_Ruzuku.php');


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
<br>

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
  <br>
<?php endif; ?>

<?php 
  if (!empty($validCodes)) {
    // Підключення до бази даних
    $conn = new PDO($dbDsn, $dbUser, $dbPass);
  
    // Формуємо значення плейсхолдерів
    $placeholders = implode(',', $validCodes);
  
    // Підготовлюємо запит
    $query_SQL = getQuerySQL($placeholders);
    $stmt_test_c = $conn->prepare($query_SQL);
  
    // Виконуємо запит зі значеннями плейсхолдерів
    $stmt_test_c->execute();
  
     
    

// Отримуємо інформацію про стовпці з результату запиту
$columns = [];
for ($i = 0; $i < $stmt_test_c->columnCount(); $i++) {
    $colMeta = $stmt_test_c->getColumnMeta($i);
    $columns[] = $colMeta['name'];
}

// Виводимо інформацію про стовпці
// var_dump($columns);

 // Виведення даних у таблиці
 echo '<div id="table-data">
 <table>
   <thead>
     <tr>
       <th>ЄДРПОУ</th>
       <th>Назва</th>
       <th>штат.прац.зв.1міс.кв</th>
       <th>ср.зарп.1міс.кв</th>
       <th>штат.прац.зв.2міс.кв</th>
       <th>ср.зарп.2міс.кв</th>
       <th>штат.прац.зв.3міс.кв</th>
       <th>ср.зарп.3міс.кв</th>
       <th>СплачВсього</th>
       <th>СплачПдв</th>
       <th>Борг</th>
       <th>БалВартПочатПер</th>
       <th>БалВартКінПер</th>
       <th>Обсяг Декл</th>
       <th>Навантаження</th>
       <th>Позитивне значення</th>
       <th>Відємне значення</th>
       <th>ЗагПлощЗемл</th>
     </tr>
   </thead>

 <tbody>';

// Виводимо заголовок таблиці
echo '<tr>';
foreach ($columns as $column) {
    echo '<th>' . iconv('WINDOWS-1251', 'UTF-8', $column) . '</th>';
}
echo '</tr></thead><tbody>';


// Виводимо дані у таблиці
while ($row = $stmt_test_c->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    foreach ($columns as $column) {
        echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row[$column]) . '</td>';
    }
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
