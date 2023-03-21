<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_config_Path.php');
require_once ($WC_2_class_auth);
require_once ($WC_2_class_all);
require_once ($WC_2_menu_php);

$WC_class_Auth_connest = new WC_class_Auth('');
$chek_auh=$WC_class_Auth_connest->WC_Auth_check_session("", false, 'You are not logged in. Please log in to continue.');

if ($chek_auh==true){
$containerClass = 'button-container';
$WC_WorkClassAll = new WorkClassAll();
$ECHO_MENU=$WC_WorkClassAll->WC_generateMenu($menuData, "menuclass");

if (is_array($menuData3)) {
    $ECHO_MENU=$WC_WorkClassAll->WC_generateMenu($menuData, "menu_class", 0);
    $accessLevel = 1;
    $ECHO_MENU_4=$WC_WorkClassAll->WC_generateMenu_4($menuData4, $containerClass, $accessLevel);
    echo $ECHO_MENU_4;
  } else {
    echo 'menuData is not an array';
  }

} else{
    echo "You are not logged in. Please log in to continue.";
}

?>

