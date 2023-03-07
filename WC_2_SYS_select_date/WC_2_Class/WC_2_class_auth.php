<?php
session_start();

class WC_class_Auth {
 private $BASE_Date_Users;

 public function __construct($BASE_Date_Users) {
    $this->BASE_Date_Users = $BASE_Date_Users;
 }

 public function login($WC_username, $WC_password, $Auth_Header) {
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


 public function WC_check_session($redirect_url) {
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
      header('Location: ' . $redirect_url);
      exit;
    } else {
      header('Location: ../WC_2_start.php');
      exit;
    }
  }
  
 }


?>
