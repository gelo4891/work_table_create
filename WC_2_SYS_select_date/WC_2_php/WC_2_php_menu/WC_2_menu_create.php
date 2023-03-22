<!DOCTYPE html>
<html>
  <?php
 require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_config_Path.php');
 require_once ($WC_2_class_auth);
 require_once ($WC_2_class_all);
 require_once ($WC_2_menu_php);
 require_once ($WC_2_config);


 $riven_dostypu=($_SESSION['boz_riven_dostyp']);
 echo $riven_dostypu;

 /*
 echo $_SESSION['last_activity'];
 echo $_SESSION['boz_riven_dostyp'];
*/
 //session_destroy();

?>
<head>


	<title>Моя сторінка</title>
  <link  type="text/css"  rel="stylesheet" href="<?php echo $WC_2_CSS_all;  ?>">
	
  
  
  <!-- Підключення бібліотеки jQuery -->
<?php


  $WCA_connect = new WorkClassAll();
  WorkClassAll::WC_2_JS_PutToDiv('WC_2_menu_create_Menu','WC_2_menu_create_content' );
?>


</head>
<body class="WC_2_menu_create_container">
	<div class="WC_2_menu_create_Menu">
		<!-- Меню -->

<?php 
// Підключення до бази даних 
$WC_conn = $WCA_connect->WC_connect_to_base_PDO('mysql',$WC_2_config_MySql_servername,$WC_2_config_MySql_base_name,$WC_2_config_MySql_base_user,$WC_2_config_MySql_base_pass,$WC_2_config_MySql_port);


$WC_class_Auth_connest = new WC_class_Auth('');
$chek_auh=$WC_class_Auth_connest->WC_Auth_check_session("", false, 'You are not logged in. Please log in to continue.');
if ($chek_auh==true){
  if (!$WC_conn) {
    echo die("Failed to connect to database");
  }
else {

// Виводимо сформований запит
  //GOOD/// $WC_query= $WCA_connect->WC_buildQuery_MySql("boz_am_menu", array(), array(),'id ',10);

  $WC_query="SELECT m.id, m.title, m.link, m.order, m.BOZ_AccessLevel, m.has_submenu, s.id as menu_id, s.title as sub_title, s.link as sub_link, s.order as sub_order, s.access_level as sub_access_level
  FROM boz_am_menu m 
  LEFT JOIN boz_am_submenu s ON m.id = s.menu_id
   ORDER BY m.order, m.id, s.order, s.id; ";
  

  // виконання запиту
  $results = $WCA_connect->WC_query_sql($WC_conn,$WC_query);
//print_r ($results);
  // виведення результатів запиту
  //echo $WC_Menu_array= $WCA_connect->WC_BuildTable($results,'Class_menu');

  $WCA_connect->WC_disconnect_from_base();



  $ECHO_MENU_55=$WCA_connect-> WC_generateMenu_5($results);
  echo $ECHO_MENU_55;

  //GOOD///   $ECHO_MENU_4=$WCA_connect->WC_generateMenu_4($results, 'button-container', 2,'BOZ_AccessLevel','_self');
  //GOOD///echo $ECHO_MENU_4;
}
} else{
  echo "You are not logged in. Please log in to continue.";
}      
 ?>

	</div>
	<div class="WC_2_menu_create_content">
		<!-- Зміст правого div-елемента буде змінюватися AJAX-запитами -->
		<p>Виберіть пункт меню, щоб відобразити вміст сторінки тут.</p>
	</div>
</body>
</html>
