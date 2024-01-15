<?php
setlocale(LC_ALL, 'uk_UA.UTF-8');

/* ==============================перевірка сесії====================================== */
require_once($_SERVER['DOCUMENT_ROOT'] . '/session/WC_2_check_sesion.php');
$session_checker1 = new SessionChecker();
$chek_auh = $session_checker1->WC_Auth_check_session(false, '/WC_2_SYS_select_date/WC_2_start.php');
/**===================================================================== */

require_once($_SERVER['DOCUMENT_ROOT'] . '/WC_ALL_Modules/2_ERPN_Test_Load/2_ERPN_conf/2_ERPN_conf.php');

if (isset($_GET['Push_date'])) {
  
  $startDate = isset($_GET['Push_date']) ? $_GET['Push_date'] : '';
  if (empty($startDate)) {
      echo " <a class='a_fontSize'>Ви не вибрали дату. Дані вибрані за 1 місяця </a>";
      $startDate = date('Y-m-d', strtotime('-1 months'));
  } else if(strtotime($startDate) < strtotime('-2 months')){
      echo "<a class='a_fontSize'>Значення більше 2 місяців. Дані можна вибрати тільки за останні 2 місяця </a>";
      $startDate = date('Y-m-d', strtotime('-2 months'));
  }

    echo '<div id="EchoDate">';
    echo "<a class='a_fontSize'> Кількість завантажених записів ЄРПН від " . $startDate . ' по ' . date('Y-m-d')."</a>";
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
                    <th>Назва дня неділі</th>
                </tr>
            </thead>
            <tbody>';

    // Виводимо заголовок таблиці

   /* echo '<tr>';
    foreach ($columns as $column) {
        echo '<th>' . iconv('WINDOWS-1251', 'UTF-8', $column) . '</th>';
    }
    echo '<th>Назва дня неділі</th>';
    echo '</tr>';*/
    
    // Створимо масив зі списком днів тижня, за які вам потрібні дані
    $daysToCheck = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');

    // Створимо масив для збереження списку дат, за які немає даних
    $missingDataDates = array();

    // Виводимо дані у таблиці
    while ($row = $stmt_test_c->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        foreach ($columns as $column) {
            echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row[$column]) . '</td>';
        }

        // Обробляємо дату і знаходимо назву дня неділі
        $date = strtotime($row['TRUNC(E.IMPDATE)']); // Перетворимо дату в Unix timestamp
        $dayOfWeek = strftime('%A', $date); // Знайдемо назву дня неділі

        // Застосовуємо стилі для комірки з назвою дня неділі
        if ($dayOfWeek == 'Saturday' or $dayOfWeek == 'Sunday') {
            echo '<td style="background: green; font-weight: bold;">' . $dayOfWeek . '</td>';
        } else {
            echo '<td>' . $dayOfWeek . '</td>';
        }

        // Застосовуємо стилі для комірки з кількістю менше 1000
        $quantity = (int)$row['COUUNT']; // Перетворюємо кількість у ціле число
        
        if ($quantity < 1000) {
            echo '<td style="background: red;">' . $quantity . '</td>';
        } else {
           // echo '<td>' . $quantity . '</td>';
        }

        echo '</tr>';

        // Перевірка на відсутність даних за будні дні
        if (in_array($dayOfWeek, $daysToCheck)) {
            // Додаємо дату в масив відсутніх даних, якщо відповідний запис не існує
            if ($quantity == 0) {
                $missingDataDates[] = date('Y-m-d', $date);
            }
        }
    }

    // Виводимо запис про відсутність даних за будні дні
    if (!empty($missingDataDates)) {
        echo '<tr><td colspan="' . (count($columns) + 2) . '" style="color: red;">Відсутні дані за наступні дні: ' . implode(', ', $missingDataDates) . '</td></tr>';
    }

    echo '</tbody></table></div>';

    // Закриття з'єднання
    $conn = null;
} else {
    echo "Немає валідних кодів для виконання запиту.";
}
?>
