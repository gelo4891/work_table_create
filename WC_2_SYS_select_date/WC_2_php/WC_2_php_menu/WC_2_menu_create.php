<!DOCTYPE html>
<html>
<head>
<?php
 require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_config_Path.php');
 require_once ($WC_2_class_auth);
 require_once ($WC_2_class_all);
 require_once ($WC_2_menu_php);
 require_once ($WC_2_config);


?>
	<title>My page</title>
  <link  type="text/css"  rel="stylesheet" href="<?php echo $WC_2_CSS_all;  ?>">

  <?php 
   WorkClassAll::WC_2_JS_PutToDiv('WC_2_menu_create_content','tesssssssss' );
  ?>

  </head>
<body>

	<div class="WC_2_menu_create_container">
		<div class="WC_2_menu_create_sidebar">
			<!-- Меню -->
				<?php 

      

$WCA_connect = new WorkClassAll();
// Підключення до бази даних 
$WC_conn = $WCA_connect->WC_connect_to_base_PDO('mysql',$WC_2_config_MySql_servername,$WC_2_config_MySql_base_name,$WC_2_config_MySql_base_user,$WC_2_config_MySql_base_pass,$WC_2_config_MySql_port);
  

$WC_class_Auth_connest = new WC_class_Auth('');
$chek_auh=$WC_class_Auth_connest->WC_Auth_check_session("", false, 'You are not logged in. Please log in to continue.');
if ($chek_auh==true){

  if (!$WC_conn) {
    echo die("Failed to connect to database");
  }
else {
// Побудова запиту
  $WC_query= $WCA_connect->WC_buildQuery_MySql("boz_am_menu", array(), array(),'id DESC',10);
  // виконання запиту
  $results = $WCA_connect->WC_query_sql($WC_conn,$WC_query);
  // виведення результатів запиту
  //echo $WC_Menu_array= $WCA_connect->WC_BuildTable($results,'Class_menu');

  $WCA_connect->WC_disconnect_from_base();

  $ECHO_MENU_4=$WCA_connect->WC_generateMenu_4($results, 'button-container', 2,'BOZ_AccessLevel','_self');
  echo $ECHO_MENU_4;
  
}
} else{
  echo "You are not logged in. Please log in to continue.";
}      
         ?>

		</div>
		<div id="test1" class="WC_2_menu_create_content">
			<!-- Зміст правого div-елемента буде змінюватися AJAX-запитами -->
		</div>
	</div>
</body>
</html>



