<?php
/*==============================перевірка сесії====================================== */
require_once ($_SERVER['DOCUMENT_ROOT'] .'/session/WC_2_check_sesion.php');
$session_checker1 = new SessionChecker();
$chek_auh=$session_checker1->WC_Auth_check_session(false,'/WC_2_SYS_select_date/WC_2_start.php');

/**===================================================================== */

 //require_once 'conf_1_Ruzuku/conf_1_Ruzuku.php';
 require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_ALL_Modules/2_ERPN_Test_Load/2_ERPN_conf/2_ERPN_conf.php');




if (isset($_GET['start'])) {
  $startDate = $_GET['start'];
  echo '<div id="EchoDate">';
  echo 'Кількість завантажених записів ЄРПН від ' . $startDate . ' по ' . date('Y-m-d');
  echo '</div>';

  
  // Підключення до бази даних
  $conn = new PDO($dbDsn, $dbUser, $dbPass);

  // Підготовлюємо запит
  $query_SQL = getQuerySQL($startDate);
  $stmt_test_c = $conn->prepare($query_SQL);

  // Виконуємо запит
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
       <th>Дата</th>
       <th>Кількість</th>
 
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

?>
