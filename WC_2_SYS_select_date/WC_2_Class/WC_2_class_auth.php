<?php
//session_start();

class WC_class_Auth {
 private $BASE_Date_Users;

 public function __construct($BASE_Date_Users) {
    $this->BASE_Date_Users = $BASE_Date_Users;
 }


public function WC_Auth_login_and_update_PDO_universal_md5($WC_Auth_conn, $WC_Auth_login, $WC_Auth_pass, $WC_Auth_table_name = 'boz_user', $WC_2_config_table_colum = array('BOZ_user_login', 'BOZ_user_pass','boz_riven_dostyp'), $WC_Auth_Header = '') {

    // Перевірка, чи є дані в таблиці
    $query_select_all = "SELECT * FROM $WC_Auth_table_name";
    $result = $WC_Auth_conn->query($query_select_all);
    if (!$result) {
        echo ("Помилка запиту до бази даних: " . $WC_Auth_conn->error );         
        return false;
    }
    $table_empty = ($result->rowCount() == 0);

    // Перевірка, чи є користувач з такими полями в таблиці
    $WC_2_config_table_colum_str = implode(",", $WC_2_config_table_colum);
    $query_select_user = "SELECT $WC_2_config_table_colum_str FROM $WC_Auth_table_name WHERE $WC_2_config_table_colum[0] = :WC_Auth_login and $WC_2_config_table_colum[1] = :WC_Auth_pass";
                                          
   $stmt = $WC_Auth_conn->prepare($query_select_user);
    $stmt->bindParam(':WC_Auth_login', $WC_Auth_login);

    $hashed_password = md5($WC_Auth_pass);
    $stmt->bindParam(':WC_Auth_pass', $hashed_password);    
    $stmt->execute();
    

    $user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($user_data) > 0) {
        $user_data = $user_data[0];
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['last_activity'] = time();       
        //$_SESSION['a_level']=$user_data1;

        foreach ($WC_2_config_table_colum as $field) {
           $_SESSION[$field] = $user_data[$field];            
            
        }
        if (!empty($WC_Auth_Header)) {
            header('Location: ' . $WC_Auth_Header);
            exit;
        } else {
            echo ('Login successful!');
        }                
    } else {
        // Якщо жодного запису в таблиці не знайдено, створюємо новий запис
        if ($table_empty) {
            $query_insert_user = "INSERT INTO $WC_Auth_table_name (". implode(",", $WC_2_config_table_colum) .") VALUES (:WC_Auth_login, :WC_Auth_pass,'0')";
            $stmt = $WC_Auth_conn->prepare($query_insert_user);
            $WC_Auth_login_adm='admin';
            $WC_Auth_pass_adm= md5($WC_Auth_pass_adm='admin');
            $stmt->bindParam(':WC_Auth_login', $WC_Auth_login_adm);
            $stmt->bindParam(':WC_Auth_pass', $WC_Auth_pass_adm);
            $stmt->execute();
            echo ('<a class="Class_Testusser">New user created!</a>');
        } else {
            echo ('<a class="Class_Testusser">Login failed!</a>');
        }
    }
    
}


/*------------------------------------------------------------------------------*/
public function WC_Auth_login_and_update_PDO_universal_hash($WC_Auth_conn, $WC_Auth_login, $WC_Auth_pass, $WC_Auth_table_name = 'boz_user', $WC_2_config_table_colum = array('BOZ_user_login', 'BOZ_user_pass','boz_riven_dostyp'), $WC_Auth_Header = '') {

    // Перевірка, чи є дані в таблиці
    $query_select_all = "SELECT * FROM $WC_Auth_table_name";
    $result = $WC_Auth_conn->query($query_select_all);
    if (!$result) {
        echo ("Помилка запиту до бази даних: " . $WC_Auth_conn->error );         
        return false;
    }
    $table_empty = ($result->rowCount() == 0);

    // Перевірка, чи є користувач з такими полями в таблиці
    $WC_2_config_table_colum_str = implode(",", $WC_2_config_table_colum);
     $query_select_user = "SELECT $WC_2_config_table_colum_str FROM $WC_Auth_table_name WHERE $WC_2_config_table_colum[0] = :WC_Auth_login";
                                          
    $stmt = $WC_Auth_conn->prepare($query_select_user);
    $stmt->bindParam(':WC_Auth_login', $WC_Auth_login);
    $stmt->execute();
    $user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
   // print_r ($user_data);
    if (count($user_data) > 0) {
        $user_data = $user_data[0];
        if (password_verify($WC_Auth_pass, $user_data["BOZ_user_pass"])) {

            if (session_status() == PHP_SESSION_ACTIVE) {
                if (!isset($_SESSION['loggedin'])) {
                    // Сесія існує, але не містить значення $_SESSION['loggedin']
                    // Тому створюємо нову сесію
                    session_destroy();
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                    $_SESSION['last_activity'] = time();   
                }
            } else {
                // Сесія не існує, тому створюємо нову сесію
                session_start();                              
                $_SESSION['loggedin'] = true;
                $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $_SESSION['last_activity'] = time();       
}

            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['last_activity'] = time();       

        foreach ($WC_2_config_table_colum as $field) {
                $_SESSION[$field] = $user_data[$field];            
            }
            if (!empty($WC_Auth_Header)) {

                header('Location: ' . $WC_Auth_Header);                
                exit;
            } else {
                echo ('Login successful!');
            } 
        } else {
            echo ('<a class="Class_Testusser">Login failed!</a>');
        }
    } else {
        // Якщо жодного запису в таблиці не знайдено, створюємо новий запис
        if ($table_empty) {
            $query_insert_user = "INSERT INTO $WC_Auth_table_name (". implode(",", $WC_2_config_table_colum) .") VALUES (:WC_Auth_login, :WC_Auth_pass,'0')";
            $stmt = $WC_Auth_conn->prepare($query_insert_user);
            $WC_Auth_login_adm='admin';
            $WC_Auth_pass_adm = password_hash('admin', PASSWORD_DEFAULT);
            $stmt->bindParam(':WC_Auth_login', $WC_Auth_login_adm);
            $stmt->bindParam(':WC_Auth_pass', $WC_Auth_pass_adm);
            $stmt->execute();
            echo ('<a class="Class_Testusser">New user created!</a>');
        } else {
            echo ('<a class="Class_Testusser">Login failed!</a>');
        }
    }
    
}
/*---------------------------------------------------------------------------------------------------*/


public function WC_Auth_login_and_update_PDO($WC_Auth_conn, $WC_Auth_login, $WC_Auth_pass, $WC_Auth_table_name = 'boz_user', $WC_2_config_table_colum = array('BOZ_user_login', 'BOZ_user_pass'), $WC_Auth_Header = '') {
    // Перевірка, чи є дані в таблиці
    $query_select_all = "SELECT * FROM `$WC_Auth_table_name`";
    $result = $WC_Auth_conn->query($query_select_all);
    if (!$result) {
        echo ("Помилка запиту до бази даних: " . $WC_Auth_conn->error );         
        return false;
    }
    //$table_empty = ($result->num_rows == 0);
    $table_empty = ($result->rowCount() == 0);

    // Перевірка, чи є користувач з такими полями в таблиці
    $WC_2_config_table_colum_str = implode("`,`", $WC_2_config_table_colum);
        $query_select_user = "SELECT  `$WC_2_config_table_colum[0]`, `$WC_2_config_table_colum[1]` FROM `$WC_Auth_table_name` WHERE `$WC_2_config_table_colum[0]` = ? and `$WC_2_config_table_colum[1]` = md5(?)";
                                          
        $stmt = $WC_Auth_conn->prepare($query_select_user);     
      //  $stmt->bind_param('ss', $WC_Auth_login, $WC_Auth_pass);


        $stmt->bindParam(1, $WC_Auth_login);
        $stmt->bindParam(2, $WC_Auth_pass);

        /*$stmt->execute();
        $result = $stmt->get_result();
        $DAte_select_table = ($result->num_rows > 0);*/
        
        $stmt->execute();
        $DAte_select_table = ($stmt->rowCount() > 0);

        if ($DAte_select_table==1) {
            $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
                
                  session_start();
                    $_SESSION['loggedin'] = true;
                    foreach ($WC_2_config_table_colum as $field) {
                        $_SESSION[$field] = $user_data[$field];
                    }
                    if (!empty($WC_Auth_Header)) {
                        header('Location: ' . $WC_Auth_Header);
                        exit;
                    } else {
                        echo ('Login successful!');
                    }                
                } 
        else {
        // Якщо жодного запису в таблиці не знайдено, створюємо новий запис
        if ($table_empty) {
            $query_insert_user = "INSERT INTO `$WC_Auth_table_name` (`" . implode("`, `", $WC_2_config_table_colum) . "`) VALUES (?, ?)";
            $stmt = $WC_Auth_conn->prepare($query_insert_user);
            $WC_Auth_login_adm='admin';
            $WC_Auth_pass_adm= md5($WC_Auth_pass_adm='admin');
            $stmt->bind_param('ss', $WC_Auth_login_adm, $WC_Auth_pass_adm);
            $stmt->execute();
            echo "Першого користувача створено: ------------<br>-----обов'язково змініть пароль--------<br>";
        } else {
            echo "Неправильний логін або пароль<br>";
        }        
    }
}

/*------------------------------------------------------------------------------*/
public function WC_Auth_login_and_update_no_PDO($WC_Auth_conn, $WC_Auth_login, $WC_Auth_pass, $WC_Auth_table_name = 'boz_user', $WC_2_config_table_colum = array('BOZ_user_login', 'BOZ_user_pass'), $WC_Auth_Header = '') {
    // Перевірка, чи є дані в таблиці
    $query_select_all = "SELECT * FROM `$WC_Auth_table_name`";
    $result = $WC_Auth_conn->query($query_select_all);
    if (!$result) {
        echo ("Помилка запиту до бази даних: " . $WC_Auth_conn->error );         
        return false;
    }
    $table_empty = ($result->num_rows == 0);
    

    // Перевірка, чи є користувач з такими полями в таблиці
    $WC_2_config_table_colum_str = implode("`,`", $WC_2_config_table_colum);
        $query_select_user = "SELECT  `$WC_2_config_table_colum[0]`, `$WC_2_config_table_colum[1]` FROM `$WC_Auth_table_name` WHERE `$WC_2_config_table_colum[0]` = ? and `$WC_2_config_table_colum[1]` = md5(?)";
                                          
        $stmt = $WC_Auth_conn->prepare($query_select_user);     
      //  $stmt->bind_param('ss', $WC_Auth_login, $WC_Auth_pass);


        $stmt->bindParam(1, $WC_Auth_login);
        $stmt->bindParam(2, $WC_Auth_pass);

        $stmt->execute();
        $result = $stmt->get_result();
        $DAte_select_table = ($result->num_rows > 0);
        


        if ($DAte_select_table==1) {
            $user_data = $result->fetch_assoc();
                
                  session_start();
                    $_SESSION['loggedin'] = true;
                    foreach ($WC_2_config_table_colum as $field) {
                        $_SESSION[$field] = $user_data[$field];
                    }
                    if (!empty($WC_Auth_Header)) {
                        header('Location: ' . $WC_Auth_Header);
                        exit;
                    } else {
                        echo ('Login successful!');
                    }                
                } 
        else {
        // Якщо жодного запису в таблиці не знайдено, створюємо новий запис
        if ($table_empty) {
            $query_insert_user = "INSERT INTO `$WC_Auth_table_name` (`" . implode("`, `", $WC_2_config_table_colum) . "`) VALUES (?, ?)";
            $stmt = $WC_Auth_conn->prepare($query_insert_user);
            $WC_Auth_login_adm='admin';
            $WC_Auth_pass_adm= md5($WC_Auth_pass_adm='admin');
            $stmt->bind_param('ss', $WC_Auth_login_adm, $WC_Auth_pass_adm);
            $stmt->execute();
            echo "Першого користувача створено: ------------<br>-----обов'язково змініть пароль--------<br>";
        } else {
            echo "Неправильний логін або пароль<br>";
        }        
    }
}

/*------------------------------------------------------------------------------*/

}


?>
