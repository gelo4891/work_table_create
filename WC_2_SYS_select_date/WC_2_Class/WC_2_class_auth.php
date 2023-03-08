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

public function WC_checkAndUpdateData($WC_Auth_conn, $WC_Auth_userLogin, $WC_Auth_userPass, $WC_Auth_QuerySelect, $WC_Auth_QueryInsert) {
  // Перевірка, чи виконався запит до бази даних
  $result = $WC_Auth_conn->query($WC_Auth_QuerySelect);
  
  if (!$result) {
      // Якщо запит не виконався, виводимо помилку та виходимо з функції
      echo "Помилка запиту до бази даних: " . $WC_Auth_conn->error;
      return false;
  }
  
  // Якщо запит виконався успішно та є дати, перевіряємо, чи є потрібні дані
  while ($row = $result->fetch_assoc()) {
      if ($row['BOZ_user_login'] == $WC_Auth_userLogin && $row['BOZ_user_pass'] == $WC_Auth_userPass) {
          echo "Дані користувача відповідають запиту";
          return true;
      }
  }
  
  // Якщо даних немає, вставляємо нові дані до таблиці
  $result = $WC_Auth_conn->query($WC_Auth_QueryInsert);
  
  if ($result) {
      echo "Нові дані користувача успішно вставлено до таблиці";
      return true;
  } else {
      echo "Помилка при вставці нових даних: " . $WC_Auth_conn->error;
      return false;
  }
}


  
 }


?>
