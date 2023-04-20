<!DOCTYPE html>
<html>

<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_config_first_include.php');
?>

<head>
  <title>Моя сторінка</title> 
  <link  type="text/css"  rel="stylesheet" href="<?php echo $WC_2_CSS_menu_create;?>">
  
  <?php
   
  //  <!-- Підключення бібліотеки jQuery -->

  $WCA_WorkClassAll = new WorkClassAll();
  WorkClassAll::WC_2_JS_PutToDiv2('WC_2_menu_create_Menu','WC_2_menu_create_content' );
   ?>

</head>
<body class="WC_2_menu_create_container">
	<div class="WC_2_menu_create_Menu">
   <?php 
		//<!-- Меню -->
/*
$WC_class_Auth_connest = new WC_class_Auth('');
$chek_auh=$WC_class_Auth_connest->WC_Auth_check_session("", false, '<a>funck--->>>You are not logged in. Please log in to continue111.</a>');
*/
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

  $ECHO_MENU_55=$WCA_WorkClassAll-> WC_generateMenu_5($results,'JS_class_menu');
  echo $ECHO_MENU_55;
}
 }else{
  echo "You are not logged in. Please log in to continue.";
}   
 
?>

</div>
	<div class='WC_2_menu_create_content'>
		<!-- Зміст правого div-елемента буде змінюватися AJAX-запитами -->
		<p>Виберіть пункт меню, щоб відобразити вміст сторінки тут.</p>
	</div>
</body>
</html>
