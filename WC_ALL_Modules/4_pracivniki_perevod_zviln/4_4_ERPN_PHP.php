<?php
setlocale(LC_ALL, 'uk_UA.UTF-8');

/* ==============================перевірка сесії====================================== */
require_once($_SERVER['DOCUMENT_ROOT'] . '/session/WC_2_check_sesion.php');
$session_checker1 = new SessionChecker();
$chek_auh = $session_checker1->WC_Auth_check_session(false, '/WC_2_SYS_select_date/WC_2_start.php');
/**===================================================================== */

require_once($_SERVER['DOCUMENT_ROOT'] . '/WC_ALL_Modules/4_pracivniki_perevod_zviln/4_ERPN_conf/4_pracivnuku_conf.php');

if (isset($_GET['Push_date'])) {
  
  // Отримуємо вибрану дату з параметру Push_date
  $startDate = isset($_GET['Push_date']) ? $_GET['Push_date'] : '';

  // Перевірка наявності вибраної дати
  if (empty($startDate)) {
      echo "<a class='a_fontSize'>Ви не вибрали дату. Дані вибрані за 1 місяця </a>";
      $startDate = date('Y-m-d', strtotime('-1 months'));
  } else if(strtotime($startDate) < strtotime('-2 months')){
      echo "<a class='a_fontSize'>Значення більше 2 місяців. Дані можна вибрати тільки за останні 2 місяця </a>";
      $startDate = date('Y-m-d', strtotime('-2 months'));
  }

    echo '<div id="EchoDate">';
    echo "<a class='b_fontSize'> Кількість завантажених записів ЄРПН від " . $startDate . ' по ' . date('Y-m-d')."</a>";
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
    echo '<div id="table-data">';
    $Shapka_table= '
     <table>
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Кількість</th>
                    <th>Назва дня неділі</th>
                </tr>
            </thead>
            <tbody>';

    // Створимо масив зі списком днів тижня, за які вам потрібні дані
    $daysToCheck = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

    // Створимо масив для збереження списку дат, за які немає даних
    $missingDataDates = array();

    // Отримуємо список дат, які мають бути присутніми у вибраному діапазоні дат
    $allDatesInRange = array();
    $currentDate = strtotime($startDate);
    $endDate = strtotime(date('Y-m-d'));
    while ($currentDate <= $endDate) {
        $allDatesInRange[] = date('Y-m-d', $currentDate);
        $currentDate = strtotime('+1 day', $currentDate);
    }



        /*========================================*/ 
    $tableRowsOutput = '';

    // Виводимо дані у таблиці
    // VIVOD VUSTRICHYH ZNACHEN
    while ($row = $stmt_test_c->fetch(PDO::FETCH_ASSOC)) {
        // Start capturing the output into the variable
        ob_start();
    
        echo '<tr>';
        foreach ($columns as $column) {
            echo '<td>' . iconv('WINDOWS-1251', 'UTF-8', $row[$column]) . '</td>';
        }

        // Обробляємо дату і знаходимо назву дня неділі
        $date = date('Y-m-d', strtotime($row['TRUNC(E.IMPDATE)'])); // Отримуємо дату в форматі Y-m-d
        $dayOfWeek = strftime('%A', strtotime($date)); // Знаходимо назву дня неділі

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
        // Capture the output and store it in the variable
        $tableRowsOutput .= ob_get_clean();
            /*========================================*/    

        // Перевірка на відсутність даних за дату
        $weekdays = array();
        $weekends = array();
       
        if (in_array($date, $allDatesInRange)) {
            // Видаляємо дату з масиву, якщо вона знайдена в результатах запиту
            $key = array_search($date, $allDatesInRange);
            unset($allDatesInRange[$key]);
        }
        
        // Перебираємо всі дати в масиві $allDatesInRange
        foreach ($allDatesInRange as $Select_date) {
            // Знаходимо назву дня тижня
            $dayOfWeek = strftime('%A', strtotime($Select_date));
            
            // Якщо день тижня є "Saturday" або "Sunday", він є вихідним днем
            if ($dayOfWeek === 'Saturday' || $dayOfWeek === 'Sunday') {
                $weekends[] = $Select_date; // Додаємо вихідний день до масиву $weekends
            } else {
                $weekdays[] = $Select_date; // Додаємо будній день до масиву $weekdays
            }
        }
    }
    // Виводимо запис про відсутність даних за дати, які не знайдені в результатах запиту
    if (!empty($allDatesInRange)) {
        $missingDataMessage = '<tr class="missing-data"><td colspan="' . (count($columns) + 2) . '" >Відсутні дані за наступні дати: ' . implode(', ', $allDatesInRange) . '</td></tr>';
    }
    
    if (!empty($weekdays)) {
        $missingWeekdaysMessage = '<tr class="missing-weekdays"><td colspan="' . (count($columns) + 2) . '">Відсутні дані за БУДНІ. Наступні дати: ' . implode(', ', $weekdays) . '</td></tr>';
    }
    
    if (!empty($weekends)) {
        $missingWeekendsMessage = '<tr class="missing-weekends"><td colspan="' . (count($columns) + 2) . '">Відсутні дані за ВИХІДНІ. Наступні дати: ' . implode(', ', $weekends) . '</td></tr>';
    }
        /*========================================*/

    echo $Shapka_table;
     /*Вивід інформаціє щодо пропущених днів та поділ на будні та вихідні для аналізу*/
    /*Output of information on missed days and division into weekdays and weekends for analysis*/
    echo $missingDataMessage;
    echo $missingWeekdaysMessage;
    echo $missingWeekendsMessage;
    echo '<tr class="CssStatustuka"><td colspan="3">Статистика</td></tr>';
    echo $tableRowsOutput;


    echo '</tbody></table></div>';

    // Закриття з'єднання
    $conn = null;
}

?>
