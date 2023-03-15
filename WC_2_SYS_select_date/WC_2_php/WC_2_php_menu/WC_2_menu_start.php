<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_config_Path.php');
require_once ($WC_2_class_auth);
require_once ($WC_2_class_all);
require_once ($WC_2_menu_php);


$WC_class_Auth_connest = new WC_class_Auth('');

$chek_auh=$WC_class_Auth_connest->WC_Auth_check_session("", false, 'You are not logged in. Please log in to continue.');

if ($chek_auh==true){
$test1=$_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_button.json';


$containerClass = 'button-container';
$WC_WorkClassAll = new WorkClassAll('','','','','','','','','','','','','','','','','');
$WC_WorkClassAll->WC_1_createButtons_text_json($test1, $containerClass);


$WC_WorkClassAll->WC_generateMenu($menuData, "menu-class");
} else{
    echo $chek_auh;
}


?>

