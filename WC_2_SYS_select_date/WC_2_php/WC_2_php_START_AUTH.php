<?php

require_once __DIR__ . '../../WC_2_Class/WC_2_class_all.php';
require_once __DIR__ . '../../WC_2_Class/WC_2_class_auth.php';
require_once __DIR__ . '../../WC_2_config/WC_2_config.php';


/*
    $servername   = "localhost";
    $username     = "gelo4891";
    $password     = "gelo1111";
    $dbname       = "base_o_zvit";
    $class_Name   = "BT_Class_Name";
*/

$WCA = new WorkClassAll('mysql', $servername, '3306', $username, $password, $dbname, 'boz_user');

//створення SQL запиту SELECT для таблиці rrrr1
$WC_query = $WCA->WC_buildQuery('select', 'boz_user', array('fields' => 'BOZ_user_login, BOZ_user_pass'));

//підключення до бази даних
$WCA->WC_connect_to_base();

//виконання запиту
$WC_Base_result = mysqli_query($WCA->conn, $WC_query);
if (!$WC_Base_result) {
    die('Invalid query: ' . mysqli_error($WCA->conn));
}

//виведення результату запиту
/*while($row = mysqli_fetch_assoc($WC_Base_result)) {
    echo "BOZ_user_login: " . $row['BOZ_user_login'] . ", BOZ_user_pass: " . $row['BOZ_user_pass'] . "<br>";
}*/


if(isset($_POST['WC_username']) && isset($_POST['WC_password'])) {
    $my_username = $_POST['WC_username'];
    $my_password = $_POST['WC_password'];
    $my_header = '../TEST/WC_2_TEST.php';
  
  /*$Select_BASE_Date_Users = array(
    array("BOZ_user_login" => "1", "BOZ_user_pass" => "1"),
    array("BOZ_user_login" => "user1", "BOZ_user_pass" => "1234"),
    array("BOZ_user_login" => "user2", "BOZ_user_pass" => "5678")
  );*/
  
  $auth = new WC_class_Auth($WC_Base_result);
  $auth->login($my_username, $my_password, $my_header);
}


?>
