<?php

require_once __DIR__ . '../../WC_2_Class/WC_2_class_all.php';
require_once __DIR__ . '../../WC_2_Class/WC_2_class_auth.php';
require_once __DIR__ . '../../WC_2_config/WC_2_config.php';


$WC_Auth_userLogin = "exampleuser";
$WC_Auth_userPass = "examplepassword";
$WC_Auth_QuerySelect = "SELECT * FROM boz_user";
$WC_Auth_QueryInsert = "INSERT INTO boz_user SET BOZ_user_login=1, BOZ_user_pass=1";



$WCA = new WorkClassAll('mysql', $servername, '3306', $username, $password, $dbname, 'boz_user');

$wc_auth1 = new WC_class_Auth('');
//створення SQL запиту SELECT для таблиці rrrr1
$WC_query = $WCA->WC_buildQuery('select', 'boz_user', array('fields' => 'BOZ_user_login, BOZ_user_pass'));

//підключення до бази даних
$WCA->WC_connect_to_base();


$WC_test=$wc_auth1->WC_checkAndUpdateData($WCA->WCA_conn, $WC_Auth_userLogin, $WC_Auth_userPass, $WC_Auth_QuerySelect, $WC_Auth_QueryInsert);


echo $WC_test ;
if (!$WC_test==true) {

    //виконання запиту
$WC_Base_result = mysqli_query($WCA->WCA_conn, $WC_query);
if (!$WC_Base_result) {
    die('Invalid query: ' . mysqli_error($WCA->WCA_conn));
}

//виведення результату запиту
/*while($row = mysqli_fetch_assoc($WC_Base_result)) {
    echo "BOZ_user_login: " . $row['BOZ_user_login'] . ", BOZ_user_pass: " . $row['BOZ_user_pass'] . "<br>";
}*/


if(isset($_POST['WC_username']) && isset($_POST['WC_password'])) {
    $my_username = $_POST['WC_username'];
    $my_password = $_POST['WC_password'];
      
  $wc_auth = new WC_class_Auth($WC_Base_result);
  $wc_auth->WC_Auth_login($my_username, $my_password, $WC_2_php_START_AUTH_header);
}





} else {
    echo "User not found in the Table   '.$dbname.'<br> Create Admin New User And Password'";
}






?>
