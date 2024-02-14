<?php
/* ==============================перевірка сесії====================================== */
/*require_once($_SERVER['DOCUMENT_ROOT'] . '/session/WC_2_check_sesion.php');
$session_checker1 = new SessionChecker();
$chek_auh = $session_checker1->WC_Auth_check_session(false, '/WC_2_SYS_select_date/WC_2_start.php');
*/
/**===================================================================== */

require_once($_SERVER['DOCUMENT_ROOT'] . '/WC_ALL_Modules/6_Slyshbovi_roli_vuborki/conf_6_Slyshbovi_roli_vuborki/conf_6_roli.php');

// Перевірка, чи отримано параметри
if (isset($_POST['codes'])) {

    // Підключення до бази даних
    $conn = new PDO($dbDsn, $dbUser, $dbPass);
    
    // Отримання параметрів
    $codes = $_POST['codes'];
    
    
    /*-----------------------------------------------------------*/
  //  echo '____test_______'.$codes.'_______<br>';
    /*-----------------------------------------------------------*/
    
    switch ($codes) {
        case 'switch-select-all':
                try {
                    
                     // Отримання данних з бази
                    $query_SQL_date = getQueryByType('PIB_ALL');
                    $stmt_upr28_date = $conn->prepare($query_SQL_date);
            
                    // Виконуємо запит
                    $stmt_upr28_date->execute();

                    // Перевірка помилок
                    $errorInfo = $stmt_upr28_date->errorInfo();
                    if ($errorInfo[0] !== PDO::ERR_NONE) {
                        echo 'Помилка виконання запиту: ' . $errorInfo[2];
                    } else {                        

                         $customColumnNames = [
                            'SL_PIB' => 'ПІБ',
                            'SL_IND' => 'Індекс',
                            'SL_NAME_PIDROZDIL'=> 'Назва підрозділу',
                            'SL_POSADA'=> 'Посада',
                            'SL_DATE'=> 'Дата службової',
                            'SL_NUMBER'=> 'Номер службової',
                            'SL_SYSTEM'=> 'Система',
                            'SL_PRUMITKA'=> 'Примітка'

                            // Додайте інші назви полів, які вам потрібні
                        ];

                        // Отримуємо дані з запиту
                        $data_upr28 = $stmt_upr28_date->fetchAll(PDO::FETCH_ASSOC);
      
                    
                        echo '<div id="div-dani">';
                            echo '<table id="table-th">';
                        
                            echo '<tr>';
                            foreach ($customColumnNames as $customColumnName) {
                                echo '<th>'.$customColumnName.'</th>';
                            }
                            echo '</tr>';
                            
                            echo '<tr>';
                                echo '<td>';
                                echo '<input type="text" id="select-PIB">';
                                echo '</td>';

                                echo '<td>';
                                echo '<input type="text" id="select-Index" >';
                                echo '</td>';

                                echo '<td>';
                                echo '<input type="text" id="select-name-pidr" >';
                                echo '</td>';

                                echo '<td>';
                                echo '</td>';

                                echo '<td>';
                                echo '</td>';

                                echo '<td>';
                                echo '<input type="text" id="select-number-sl" >';
                                echo '</td>';

                                echo '<td>';
                                    echo ' 
                                    <select id="select-system">
                                        <option disabled selected value="0">Системи</option>
                                        <option value="ІКС Управління документами">ІКС "Управління документами"</option>
                                        <option value="ІКС Податковий Блок(основна)">ІКС "Податковий Блок"(основна)</option>
                                        <option value="ІКС Податковий Блок (додаткові ролі)">ІКС "Податковий Блок"(додаткові ролі)</option>
                                        <option value="ІКС Єдине вікно подання звітності">ІКС "Єдине вікно подання звітності (Архів)"</option>
                                        <option value="ІКС Адміністративне та судове оскарження">ІКС "Адміністративне та судове оскарження"</option> 
                                        <option value="Електронний кабінет платника">"Електронний кабінет платника"</option>  
                                        <option value="АС Акцизні марки">АС "Акцизні марки"</option> 
                                        <option value="ІКС Міжнародний автосатичний обмін">ІКС "Міжнародний автосатичний обмін (-450006)"</option> 
                                        <option value="Internet">ІКС "Internet"</option> 
                                        <option value="Локальна Мережа">Локальна Мережа"</option> 
                                        <option value="Черкаська">Черкаська</option> 
                                        <option value="USB-флешки">USB-флешки</option>
                                        <option value="Фоссмаіл (Outlook)">Фоссмаіл (Outlook)</option>
                                    </select> ';                                
                                echo '</td>';

                                echo '<td>';
                                echo '</td>';

                                echo '</td>';
                            echo '</tr>';

                            echo '</table>';
                        echo '</div>';


                        echo '<div>';
                        
                        echo '<table id="dani-slugbova">';
                      
                       foreach ($data_upr28 as $row) {                            
                           foreach ($row as $column => $value) {
                               
                                echo '<td>';
                                echo htmlspecialchars(iconv('WINDOWS-1251', 'UTF-8', $value));
                                echo '</td>';
                            }
                        
                            echo '</tr>';
                        }
                        
                        echo '</table>';
                        echo '</div>';
                        echo '<br>';
 
                    }

                } catch (PDOException $e) {
                    echo 'Помилка: ' . $e->getMessage();
                }

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
