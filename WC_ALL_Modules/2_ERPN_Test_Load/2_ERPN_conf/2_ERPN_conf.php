<?php

/*===================================================================== */
/*require_once ($_SERVER['DOCUMENT_ROOT'] .'/session/WC_2_check_sesion.php');
$session_checker1 = new SessionChecker();
$chek_auh=$session_checker1->WC_Auth_check_session(false,'/WC_2_SYS_select_date/WC_2_start.php');

/**===================================================================== */


  $dbDsn = 'odbc:ODBS_dell720';
  $dbUser = 'analiz';
  $dbPass = 'reg_analiz';  
  
  
  // Функція для формування SQL запиту
  function getQuerySQL($placeholders) {
      return " SELECT 
      trunc(e.impdate), count(*) couunt
      FROM ANALIZ.ERPN_HD e
      where trunc(e.impdate)>=to_date('$placeholders','yyyy-mm-dd')
      group by trunc(e.impdate)
      order by 1 desc";

}


  
?>
