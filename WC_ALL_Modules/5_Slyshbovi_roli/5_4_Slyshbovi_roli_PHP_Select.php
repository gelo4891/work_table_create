<?php
//setlocale(LC_ALL, 'uk_UA.UTF-8');


/* ==============================перевірка сесії====================================== */
/*require_once($_SERVER['DOCUMENT_ROOT'] . '/session/WC_2_check_sesion.php');
$session_checker1 = new SessionChecker();
$chek_auh = $session_checker1->WC_Auth_check_session(false, '/WC_2_SYS_select_date/WC_2_start.php');
*/
/**===================================================================== */

require_once($_SERVER['DOCUMENT_ROOT'] . '/WC_ALL_Modules/5_Slyshbovi_roli/conf_5_Slyshbovi_roli/conf_5_roli.php');

// Перевірка, чи отримано параметри
if (isset($_POST['codes'])) {

    // Підключення до бази даних
    $conn = new PDO($dbDsn, $dbUser, $dbPass);
    
    // Отримання параметрів
    $codes = $_POST['codes'];
    
    
    /*-----------------------------------------------------------*/
    //echo '____test_______'.$codes.'_______<br>';
    /*-----------------------------------------------------------*/
    
    switch ($codes) {
        case 'rozblok-loading-krok2':

            echo 'test1____rozblok-loading-krok2====>_______' . $codes . '_______<br>';
            // Підготовлюємо запит
            $query_SQL = getQuerySQL_PIB();
            $stmt_test_c = $conn->prepare($query_SQL);
    
            // Виконуємо запит
            $stmt_test_c->execute();
    
            // Отримуємо інформацію про стовпці з результату запиту
            $columns = [];
            for ($i = 0; $i < $stmt_test_c->columnCount(); $i++) {
                $colMeta = $stmt_test_c->getColumnMeta($i);
                $columns[] = $colMeta['name'];
            }
    
            // Отримуємо дані з запиту
            $data = $stmt_test_c->fetchAll(PDO::FETCH_ASSOC);
    
            // Виводимо випадаюче меню
            echo '<div id="div-select">';
            echo '<select id="PhpSelectMenu">';
            echo '<option disabled selected value="">Оберіть працівника</option>';
            foreach ($data as $row) {
                $value = htmlspecialchars(iconv('WINDOWS-1251', 'UTF-8', $row[$columns[2]]));
                echo '<option class="select-option" value="' . $value . '">';
                echo 'Штатка за-->' . htmlspecialchars(iconv('WINDOWS-1251', 'UTF-8', $row[$columns[0]])) . '  ||  ' . $value;
                echo '</option>';
            }
            echo '</select>';
            echo '<div>';
            break;
    
            case 'insert-upadate-date':
                $dateValue = isset($_POST['date']) ? $_POST['date'] : '';
                $nomerValue = isset($_POST['nomer']) ? $_POST['nomer'] : '';
        
                echo '___________' . $codes . '_______<br>';
                echo 'Date insert with dateValue: ' . $dateValue . ' and nomerValue: ' . $nomerValue;
                break;
    
        default:
            // Якщо параметри не було передано, повертаємо порожню відповідь або виконуємо іншу логіку
            echo 'Invalid request';
            echo '___Invalid request======________' . $codes . '_______<br>';
            break;
    }
}
?>
