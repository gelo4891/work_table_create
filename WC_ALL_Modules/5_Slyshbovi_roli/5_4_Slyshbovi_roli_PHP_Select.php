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
        case 'rozblok-loading-krok1':
           
            // Підготовлюємо запит
            $query_SQL = getQueryByType('PIB');
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
    
    
/*---------------------------------------------------------------------------------------------------------*/

            case 'insert-upadate-date':
                $SL_DATE = isset($_POST['SL_DATE']) ? $_POST['SL_DATE'] : '';
                $SL_NUMBER = isset($_POST['SL_NUMBER']) ? $_POST['SL_NUMBER'] : '';
                $SL_SYSTEM = isset($_POST['SL_SYSTEM']) ? $_POST['SL_SYSTEM'] : '';
                $IP_SHTAT_INDEX = isset($_POST['IP_SHTAT_INDEX']) ? $_POST['IP_SHTAT_INDEX'] : '';         
                $IP_SHTAT_MONTH = isset($_POST['IP_SHTAT_MONTH']) ? $_POST['IP_SHTAT_MONTH'] : '';
                $IP_SHTAT_NAME_PIDR = isset($_POST['IP_SHTAT_NAME_PIDR']) ? $_POST['IP_SHTAT_NAME_PIDR'] : '';
                $IP_SHTAT_PIB = isset($_POST['IP_SHTAT_PIB']) ? $_POST['IP_SHTAT_PIB'] : '';
                $IP_SHTAT_POSADA = isset($_POST['IP_SHTAT_POSADA']) ? $_POST['IP_SHTAT_POSADA'] : '';
                $IP_SHTAT_DATE_START = isset($_POST['IP_SHTAT_DATE_START']) ? $_POST['IP_SHTAT_DATE_START'] : '';
                $SL_PRUMITKA='';

                // convert params
                $IP_SHTAT_PIB_windows1251 = iconv('UTF-8', 'WINDOWS-1251', $IP_SHTAT_PIB);
                $IP_SHTAT_NAME_PIDR_windows1251 = iconv('UTF-8', 'WINDOWS-1251', $IP_SHTAT_NAME_PIDR);
                $IP_SHTAT_POSADA_windows1251 = iconv('UTF-8', 'WINDOWS-1251', $IP_SHTAT_POSADA);
                $SL_SYSTEM_windows1251 = iconv('UTF-8', 'WINDOWS-1251', $SL_SYSTEM);
                $SL_PRUMITKA_windows1251 = iconv('UTF-8', 'WINDOWS-1251', $SL_PRUMITKA);
                
                $query_SQL_date = getQueryByType(
                    'DATE_INSERT',
                    $IP_SHTAT_PIB_windows1251,
                    $IP_SHTAT_INDEX, 
                    $IP_SHTAT_NAME_PIDR_windows1251,
                    $IP_SHTAT_POSADA_windows1251,
                    $SL_DATE,
                    $SL_NUMBER,
                    $SL_SYSTEM_windows1251, 
                    $SL_PRUMITKA_windows1251
                    
                );

                $stmt_upr28_date = $conn->prepare($query_SQL_date);
                
                // Встановлюємо значення параметрів
                $stmt_upr28_date->bindParam(':SL_PIB', $IP_SHTAT_PIB_windows1251, PDO::PARAM_STR);
                $stmt_upr28_date->bindParam(':SL_IND', $IP_SHTAT_INDEX, PDO::PARAM_STR);
                $stmt_upr28_date->bindParam(':SL_NAME_PIDROZDIL', $IP_SHTAT_NAME_PIDR_windows1251, PDO::PARAM_STR);
                $stmt_upr28_date->bindParam(':SL_POSADA', $IP_SHTAT_POSADA_windows1251, PDO::PARAM_STR);
                $stmt_upr28_date->bindParam(':SL_DATE', $SL_DATE, PDO::PARAM_STR);
                $stmt_upr28_date->bindParam(':SL_NUMBER', $SL_NUMBER, PDO::PARAM_STR);
                $stmt_upr28_date->bindParam(':SL_SYSTEM', $SL_SYSTEM_windows1251, PDO::PARAM_STR);
                $stmt_upr28_date->bindParam(':SL_PRUMITKA', $SL_PRUMITKA_windows1251, PDO::PARAM_STR);

                // Виконуємо запит
                $stmt_upr28_date->execute();

                echo  'SL_DATE:' . $SL_DATE.'<br>';
                echo  'SL_NUMBER:' . $SL_NUMBER.'<br>';
                echo  'SL_SYSTEM:' . $SL_SYSTEM.'<br>';                
                echo  'SL_IND:' . $IP_SHTAT_INDEX.'<br>';
                echo  'IP_SHTAT_MONTH:' .$IP_SHTAT_MONTH.'<br>';
                echo  'IP_SHTAT_NAME_PIDR:' .$IP_SHTAT_NAME_PIDR.'<br>';
                echo  'IP_SHTAT_PIB:' .$IP_SHTAT_PIB.'<br>';
                echo  'IP_SHTAT_POSADA:' .$IP_SHTAT_POSADA .'<br>';
                echo  'IP_SHTAT_DATE_START:' .$IP_SHTAT_DATE_START .'<br>';
            break;
   /*---------------------------------------------------------------------------------------------------------*/
                case 'select-date-pib':
                    try {
                        echo '....................Дані про службові......................<br>';
                        $dateValue = isset($_POST['PIB']) ? $_POST['PIB'] : '';
                    
                       // echo '<input type="text" id="krok2-PIB-name" value="'.htmlspecialchars($dateValue).'">';
    
                        $query_SQL_date = getQueryByType('PIB_ALL', $dateValue);
                        $stmt_upr28_date = $conn->prepare($query_SQL_date);
                
                        // Виконуємо запит
                        $stmt_upr28_date->execute();
    
                        // Перевірка помилок
                        $errorInfo = $stmt_upr28_date->errorInfo();
                        if ($errorInfo[0] !== PDO::ERR_NONE) {
                            echo 'Помилка виконання запиту: ' . $errorInfo[2];
                        } else {

                            $columns = [];
                            for ($i = 0; $i < $stmt_upr28_date->columnCount(); $i++) {
                                $colMeta = $stmt_upr28_date->getColumnMeta($i);
                                $columns[] = $colMeta['name'];
                            }

                            // Отримуємо дані з запиту
                            $data_upr28 = $stmt_upr28_date->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($data_upr28 as $row) {
                                foreach ($row as $column => $value) {
                                 //   echo htmlspecialchars(iconv('WINDOWS-1251', 'UTF-8', $column)) . ': ' ;
                                    echo htmlspecialchars(iconv('WINDOWS-1251', 'UTF-8', $value)) . '<br>';
                                }
                                echo '<hr>';
                            }                         
                        }

                    } catch (PDOException $e) {
                        echo 'Помилка: ' . $e->getMessage();
                    }

                    break;
 /*------------------------------------------------------------------------------------------------------------------------------ */ 
                    case 'select-date-pidrozdil':                     

                            $dateValue = isset($_POST['PIB']) ? $_POST['PIB'] : '';
                            $query_SQL_date1 = getQueryByType('PIB_DATE', $dateValue);
                            $stmt_upr28_date1 = $conn->prepare($query_SQL_date1);
                        
                            // Виконуємо запит
                            $stmt_upr28_date1->execute();
                        
                            // Перевірка помилок
                            $errorInfo = $stmt_upr28_date1->errorInfo();
                        
                            if ($errorInfo[0] !== PDO::ERR_NONE) {
                                $response = json_encode(['error' => 'Помилка виконання запиту: ' . $errorInfo[2]]);
                            } else {
                                // Отримуємо дані з запиту
                                $data_upr28 = $stmt_upr28_date1->fetchAll(PDO::FETCH_ASSOC); 

                                $data_upr28_utf8 = array_map(function ($row) {
                                    return array_map(function ($value) {
                                        return htmlspecialchars(iconv('WINDOWS-1251', 'UTF-8', $value), ENT_QUOTES, 'UTF-8');
                                    }, $row);
                                }, $data_upr28);
                           }

                        // Повертаємо JSON-рядок для подальшого використання
                        echo json_encode($data_upr28_utf8);
                        
                    break;   
                    
    /*---------------------------------------------------------------------------------------------------------*/         

        default:
            // Якщо параметри не було передано, повертаємо порожню відповідь або виконуємо іншу логіку
            echo 'Invalid request';
            echo '___Invalid request======________' . $codes . '_______<br>';
            break;
    }
}
?>
