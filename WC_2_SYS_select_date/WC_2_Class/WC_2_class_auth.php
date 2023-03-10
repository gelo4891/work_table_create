<?php
session_start();

class WC_class_Auth {
 private $BASE_Date_Users;

 public function __construct($BASE_Date_Users) {
    $this->BASE_Date_Users = $BASE_Date_Users;
 }

 public function WC_Auth_login($WC_username, $WC_password, $Auth_Header) {
    foreach ($this->BASE_Date_Users as $user) {
      if($WC_username === $user['BOZ_user_login'] && $WC_password === $user['BOZ_user_pass']) {
        $_SESSION['loggedin'] = true;
        $_SESSION['BOZ_user_login'] = $WC_username;
        echo 'Login successful!';
        header('Location: ' . $Auth_Header);
        exit;
      }
    }
    echo 'Invalid login credentials';
    exit;
 }

/*-------------------Check session--------------------------old function------------------------------------------------------*/
/*
 public function WC_check_session($WC_check_ses_redirect_url, $WC_check_ses_should_redirect = true) {
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
      if ($WC_check_ses_should_redirect) {
        header('Location: ' . $WC_check_ses_redirect_url);
        exit;
      }
    } else {
      if ($WC_check_ses_should_redirect) {
        header('Location: ../start.php');
        exit;
      }
    }
  }

  public function WC_check_auth($WC_check_ses_should_redirect = true) {
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        return true;
    } else {
        if ($WC_check_ses_should_redirect) {
            die('Помилка: ви не увійшли в систему або ваша сесія не дійсна');
        }
        return false;
    }
}
*/
/*--------Check session--------------------------new function---------*/
function check_session($redirect_url = '', $should_redirect = true, $error_message = 'Your session is not reliable.') {
    $reliable_session = false;
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        // Check if session has not expired and user agent has not changed
        if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] === $_SERVER['HTTP_USER_AGENT'] &&
            isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) < 3600) {
            $reliable_session = true;
            $_SESSION['last_activity'] = time();
        }
    }
    if (!$reliable_session && $should_redirect) {
        if (!empty($redirect_url)) {
            header('Location: ' . $redirect_url);
            exit;
        } else {
            echo $error_message;
        }
    }
    return $reliable_session;
}

/*приклад використання
$session_reliable = check_session('../login.php');

if (!$session_reliable) {
    // Do something if session is not reliable
} else {
    // Do something if session is reliable
}
*/
/*---------------------------------------------------------------------------------------------------*/


public function WC_Auth_login_and_update($WC_Auth_conn, $WC_Auth_login, $WC_Auth_pass, $WC_Auth_table_name = 'boz_user', $WC_2_config_table_colum = array('BOZ_user_login', 'BOZ_user_pass'), $WC_Auth_Header = '') {
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
        $stmt->bind_param('ss', $WC_Auth_login, $WC_Auth_pass);

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

}


?>
