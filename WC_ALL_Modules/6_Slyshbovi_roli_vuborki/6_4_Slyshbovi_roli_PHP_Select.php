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
                            'SL_PRUMITKA'=> 'Примітка',
                            'Коригування'=> 'Коригування'

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
                                echo '<input type="text" id="select-name-posada" style="display:none">';
                                echo '</td>';

                                echo '<td>';
                                echo '<input type="text" id="select-name-date" style="display:none">';
                                echo '</td>';

                                echo '<td>';
                                echo '<input type="text" id="select-number-sl" >';
                                echo '</td>';

                                echo '<td>';
                                    echo ' 
                                    <select id="select-system-filter">
                                        <option selected value="0">ВСІ Системи</option>
                                        <option value="ІКС Управління документами">ІКС "Управління документами"</option>
                                        <option value="ІКС Податковий Блок (основна)">ІКС "Податковий Блок" (основна)</option>
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
                            $uniqueId = isset($row['ROWID']) ? $row['ROWID'] : 'ROWID'; // Використовуйте існуючий ROWID або створіть новий, якщо він не існує
                            echo '<tr data-row-id="' . $uniqueId . '">';
                            
                            foreach ($row as $column => $value) {
                                // Перевірте, чи поточна колонка має бути редагована
                                if ($column != 'ROWID') {
                                    // Якщо колонка не потребує редагування, виводимо звичайний текст
                                    echo '<td>';
                                    echo htmlspecialchars(iconv('WINDOWS-1251', 'UTF-8', $value));
                                    echo '</td>';
                            }
                        }
                            echo '<td class="exclude-from-export">';
                            echo '<button id="id-edit-btn" class="edit-btn">Edit</button>';
    
                            echo '</td>';
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
    /*------------------------------------------------------------*/
        case 'update-date':
            try {
                // Перевірка наявності обов'язкових параметрів
                $SL_ROW = isset($_POST['ROWID']) ? $_POST['ROWID'] : '';
                $SL_DATE = isset($_POST['SL_DATE']) ? $_POST['SL_DATE'] : '';
                $SL_NUMBER = isset($_POST['SL_NUMBER']) ? $_POST['SL_NUMBER'] : '';
                $SL_PRUMITKA = isset($_POST['SL_PRUMITKA']) ? $_POST['SL_PRUMITKA'] : '';

                // convert params
                $SL_NUMBER_windows1251 = iconv('UTF-8', 'WINDOWS-1251', $SL_NUMBER);
                $SL_PRUMITKA_windows1251 = iconv('UTF-8', 'WINDOWS-1251', $SL_PRUMITKA);

               // Отримання данних з бази
                $query_SQL_date = getQueryByType('DATE_UPDATE', 
                    $SL_DATE
                );               

                $stmt_upr28_date = $conn->prepare($query_SQL_date);

                // Встановлення параметрів та виконання запиту
                $stmt_upr28_date->bindParam(':SL_DATE', $SL_DATE, PDO::PARAM_STR);
                $stmt_upr28_date->bindParam(':SL_NUMBER', $SL_NUMBER_windows1251, PDO::PARAM_STR);
                $stmt_upr28_date->bindParam(':SL_PRUMITKA', $SL_PRUMITKA_windows1251, PDO::PARAM_STR);
                $stmt_upr28_date->bindParam(':SL_ROW', $SL_ROW, PDO::PARAM_STR);

                // Виконання запиту
                $stmt_upr28_date->execute();
            
                // Перевірка помилок
                $errorInfo = $stmt_upr28_date->errorInfo();
                if ($errorInfo[0] !== PDO::ERR_NONE) {
                    echo 'Помилка виконання запиту: ' . iconv('UTF-8', 'WINDOWS-1251', $errorInfo[2]);
                }

         } catch (PDOException $e) {
            echo 'Помилка: ' . $e->getMessage();               
            }   
            
        break;  


    /*---------------------------------------------------------------------------------------------------------*/         
    case 'switch-info-update':
       try {      
            $SL_ROW = isset($_POST['SL_ROW']) ? $_POST['SL_ROW'] : '';
           
      
            // Отримання данних з бази
            $query_SQL_date = getQueryByType('PIB_UPDATE_INFO',$SL_ROW);
            $stmt_upr28_date = $conn->prepare($query_SQL_date);

            // Виконуємо запит
            $stmt_upr28_date->execute();

            // Перевірка помилок
            $errorInfo = $stmt_upr28_date->errorInfo();
            if ($errorInfo[0] !== PDO::ERR_NONE) {
                echo 'Помилка виконання запиту: ' . $errorInfo[2];
            } else {  
                
              // Отримуємо дані з запиту
              $data_upr28 = $stmt_upr28_date->fetchAll(PDO::FETCH_ASSOC);   

            $customColumnNames = [
                'ROWID'=> 'ROWID',
                'SL_PIB' => 'ПІБ',
                'SL_IND' => 'Індекс',
                'SL_NAME_PIDROZDIL'=> 'Назва підрозділу',
                'SL_POSADA'=> 'Посада',
                'SL_DATE'=> 'Дата службової',
                'SL_NUMBER'=> 'Номер службової',
                'SL_SYSTEM'=> 'Система',
                'SL_PRUMITKA'=> 'Примітка',
                // Додайте інші назви полів, які вам потрібні
            ];

              echo '<table id="data-update-slugbova">';

              foreach ($data_upr28 as $row) {                      
                echo '<tr>';
                echo '<th colspan="2">';
                echo 'Коригування даних';
                echo '</th>';
                echo '</tr>';
                              
                foreach ($row as $column => $value) {
                    // Перевірте, чи поточна колонка має бути редагована
                    echo '<tr>';
                    echo '<td>'.$customColumnNames[$column].'</td>';
                
                    if  (in_array($column, ['ROWID'])) {
                        echo '<td oracle_row_id="'.$value.'">';
                        echo  htmlspecialchars(iconv('WINDOWS-1251', 'UTF-8', $value)) ;
                        echo '</td>';
                    }
                    else if ($column === 'SL_DATE') {
                        // Форматуємо дату в формат "YYYY-MM-DD"
                        $formattedDate = date('Y-m-d', strtotime($value));                
                        echo '<td>';
                        echo '<input type="date" data-column-name="' . $column . '" value="' . $formattedDate . '" ></input>';
                        echo '</td>';                        
                    } else if (in_array($column, ['SL_NUMBER', 'SL_PRUMITKA'])) {
                        echo '<td>';
                        echo '<input type="text" data-column-name="' . $column . '" value="' . htmlspecialchars(iconv('WINDOWS-1251', 'UTF-8', $value)) . '" ></input>';
                        echo '</td>';
                    } else {
                        // Якщо колонка не потребує редагування, виводимо звичайний текст
                        echo '<td>';
                        echo htmlspecialchars(iconv('WINDOWS-1251', 'UTF-8', $value));
                        echo '</td>';
                    }                    
                    echo '</tr>';  
                }   

                echo '<tr>';
                echo '<td class="button-exclude-from-export">';
                echo '<button class="save-btn">Save</button>';
                echo '</td>';

                echo '<td>';                
                echo '<button class="cancel-btn">Cancel</button>'; 
                echo '</td>';

                echo '</tr>';
              }

             echo '</table>';

           } 
           
        }catch (PDOException $e) {
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
