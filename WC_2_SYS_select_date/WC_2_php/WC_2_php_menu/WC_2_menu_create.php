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

	<title>Моя сторінка</title>
  <link  type="text/css"  rel="stylesheet" href="<?php echo $WC_2_CSS_all;  ?>">
	<!-- Підключення бібліотеки jQuery -->
<?php
  $WCA_connect = new WorkClassAll();
  WorkClassAll::WC_2_JS_PutToDiv('WC_2_menu_create_container','WC_2_menu_create_content' );
?>


</head>
<body class="WC_2_menu_create_container">
	<div class="WC_2_menu_create_sidebar">
		<!-- Меню -->
		<ul>
			<li><a href="Menu_1_test.html">Пункт меню 1</a></li>
			<li><a href="Menu_2_test.php">Пункт меню 2</a></li>
			<li><a href="Menu_3_test.php ">Пункт меню 3</a></li>
		</ul>
	</div>
	<div class="WC_2_menu_create_content">
		<!-- Зміст правого div-елемента буде змінюватися AJAX-запитами -->
		<p>Виберіть пункт меню, щоб відобразити вміст сторінки тут.</p>
	</div>
</body>
</html>
