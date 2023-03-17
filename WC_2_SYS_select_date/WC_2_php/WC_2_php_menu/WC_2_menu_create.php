<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_config_Path.php');
require_once ($WC_2_class_auth);
require_once ($WC_2_class_all);
require_once ($WC_2_menu_php);
require_once ($WC_2_config);

//$WCA_connect = new WorkClassAll('mysql', $WC_2_config_MySql_servername, $WC_2_config_MySql_port, $WC_2_config_MySql_base_user, $WC_2_config_MySql_base_pass, $WC_2_config_MySql_base_name, $WC_2_config_MySql_table_name);
$WCA_connect = new WorkClassAll();
   // $WCA_connect = new WorkClassAll('oracle', $WC_2_config_servername, $WC_2_config_port, $WC_2_config_base_user, $WC_2_config_base_pass, $WC_2_config_base_name, $WC_2_config_table_name);
   // Підключення до бази даних 
   $WC_conn = $WCA_connect->WC_connect_to_base_PDO('mysql',$WC_2_config_MySql_servername,$WC_2_config_MySql_base_name,$WC_2_config_MySql_base_user,$WC_2_config_MySql_base_pass,$WC_2_config_MySql_port);
    // Побудова запиту
    $WC_query= $WCA_connect->WC_buildQuery_MySql("boz_am_menu", array(), array(),'id DESC',10);
    // виконання запиту
    $results = $WCA_connect->WC_query_sql($WC_conn,$WC_query);
    // виведення результатів запиту
    //echo $WC_Menu_array= $WCA_connect->WC_BuildTable($results,'Class_menu');

    $WCA_connect->WC_disconnect_from_base();


    $ECHO_MENU_4=$WCA_connect->WC_generateMenu_4($results, 'button-container', 2,'BOZ_AccessLevel');
    echo $ECHO_MENU_4;

   /*
    if (!$conn) {
      echo die("Failed to connect to database");
    }
        // Тут виконуємо запити до бази даних
    if ($conn){
      //$WCA_connect->WC_buildQuery_MySql($WC_2_config_MySql_tname_menu,);


      
//echo $query ;
      //$result = $pdo->query($query);
    }





/*

$WC_class_Auth_connest = new WC_class_Auth('');
$chek_auh=$WC_class_Auth_connest->WC_Auth_check_session("", false, 'You are not logged in. Please log in to continue.');
if ($chek_auh==true){

$containerClass = 'button-container';
$WC_WorkClassAll = new WorkClassAll();
//$WC_WorkClassAll->WC_1_createButtons_text_json($WC_2_button_json, $containerClass);
$ECHO_MENU=$WC_WorkClassAll->WC_generateMenu($menuData, "menuclass");




if (is_array($menuData3)) {
    $ECHO_MENU=$WC_WorkClassAll->WC_generateMenu($menuData, "menu_class", 0);
   // ECHO $ECHO_MENU;    

echo '<----------------------------------------------------------------------------->';

    $accessLevel = 1;
    $ECHO_MENU_4=$WC_WorkClassAll->WC_generateMenu_4($menuData4, $containerClass, $accessLevel);
    echo $ECHO_MENU_4;
  } else {
    echo 'menuData is not an array';
  }

  //ECHO $ECHO_MENU;





} else{
    echo "You are not logged in. Please log in to continue.";
}

*/
?>

