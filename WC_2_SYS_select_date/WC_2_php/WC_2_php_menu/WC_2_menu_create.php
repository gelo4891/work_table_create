<!DOCTYPE html>
<html>
  <?php

  require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_config_BAse.php');
  require_once ($WC_2_config_base_CL);
  
  $WCA_connect = new WC_CL_Conn_Base(); 
    // Підключення до бази даних параметри по замовчуванню  
  $WC_conn = $WCA_connect->WC_CL_conn_base_func();    

  $WC_2_class_auth=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_class_auth');
  $WC_2_class_all=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_class_all');
  $WC_2_CSS_all=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_CSS_all');
  $SQL_create_menu=$WCA_connect->WC_CL_conn_query_sql($WC_conn, 'SQL_create_menu');
  $WC_2_CSS_menu_create=$WCA_connect->WC_CL_conn_query_sql($WC_conn, '$WC_2_CSS_menu_create');


  require_once ($WC_2_class_auth);
  require_once ($WC_2_class_all);

?>

<head>
	<title>Моя сторінка</title>
  <link  type="text/css"  rel="stylesheet" href="<?php echo $WC_2_CSS_menu_create;  ?>">
  <link  type="text/css"  rel="stylesheet" href="<?php echo $WC_2_CSS_all;  ?>">
    <!-- Підключення бібліотеки jQuery -->
<?php
  $WCA_WorkClassAll = new WorkClassAll();
  WorkClassAll::WC_2_JS_PutToDiv('WC_2_menu_create_Menu','WC_2_menu_create_content' );
?>



</head>
<body class="WC_2_menu_create_container">
	<div class="WC_2_menu_create_Menu">
		<!-- Меню -->

<?php 
$WC_class_Auth_connest = new WC_class_Auth('');
$chek_auh=$WC_class_Auth_connest->WC_Auth_check_session("", false, '<a>You are not logged in. Please log in to continue.</a>');
if ($chek_auh==true){
  if (!$WC_conn) {
    echo die("Failed to connect to database");
  }
else {



// Виводимо сформований запит
  $riven_dostypu = $_SESSION['boz_riven_dostyp'];
  $params = array(':riven_dostypu' => $riven_dostypu);
       
  $results = $WCA_WorkClassAll->WC_query_sql2($WC_conn, $SQL_create_menu, $params);
      
  $WCA_WorkClassAll->WC_disconnect_from_base();

  $ECHO_MENU_55=$WCA_WorkClassAll-> WC_generateMenu_5($results);
  echo $ECHO_MENU_55;
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
