<?php

/*===================================================================== */
/*require_once ($_SERVER['DOCUMENT_ROOT'] .'/session/WC_2_check_sesion.php');
$session_checker1 = new SessionChecker();
$chek_auh=$session_checker1->WC_Auth_check_session(false,'/WC_2_SYS_select_date/WC_2_start.php');

/**===================================================================== */


$dbDsn = 'odbc:ODBS_dell720';
$dbUser = 'upr28';
$dbPass = 'upr28';   
  
  
  // Функція для формування SQL запиту
  function getQuerySQL($placeholders) {
      return " SELECT 
      trunc(e.impdate), count(*) couunt
      FROM ANALIZ.ERPN_HD e
      where trunc(e.impdate)>=to_date('$placeholders','yyyy-mm-dd')
      group by trunc(e.impdate)
      order by 1 desc";
}

function getQuerySQL_PIB() {
  return " SELECT 
  IP_SHTAT_MONTH, IP_SHTAT_INDEX, IP_SHTAT_PIB,  
 IP_SHTAT_NAME_PIDR, IP_SHTAT_POSADA, IP_SHTAT_NAPRYAM
FROM UPR28.IP_2021_SHTAT
where IP_SHTAT_MONTH= (select distinct(max(IP_SHTAT_MONTH)) from UPR28.IP_2021_SHTAT )
order by IP_SHTAT_PIB";
}
  
?>
