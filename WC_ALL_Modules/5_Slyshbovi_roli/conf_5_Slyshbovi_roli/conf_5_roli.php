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

function getQuerySQL_PIB_one($UserPib) {
  return " SELECT SL_PIB, SL_IND, SL_NAME_PIDROZDIL, 
  SL_POSADA, SL_DATE, SL_NUMBER, SL_SYSTEM, SL_PRUMITKA 
  FROM UPR28.OLEG_SL_YDO_BLOK WHERE REPLACE(UPPER(SL_PIB), ' ', '') = REPLACE(UPPER('$UserPib'), ' ', '')";
}

function getQuerySQL_PIB_one_test($UserPib) {
  // Перекодувати $UserPib в WINDOWS-1251
  $userPibWindows1251 = iconv('UTF-8', 'WINDOWS-1251', $UserPib);

  return "SELECT SL_PIB, SL_IND, SL_NAME_PIDROZDIL, 
          SL_POSADA, SL_DATE, SL_NUMBER, SL_SYSTEM, SL_PRUMITKA 
          FROM UPR28.OLEG_SL_YDO_BLOK 
          WHERE REPLACE(UPPER(SL_PIB), ' ', '') = REPLACE(UPPER('$userPibWindows1251'), ' ', '')  order by sl_date desc";
}

/*
function getQuerySQL_insert_update($Inser_or_update,$user_date) {

switch(){
  case 'date_insert':
  break;

  case 'date_update':
  break;
  
}

  // Перекодувати $UserPib в WINDOWS-1251
  $userPibWindows1251 = iconv('UTF-8', 'WINDOWS-1251', $UserPib);

  return "SELECT SL_PIB, SL_IND, SL_NAME_PIDROZDIL, 
          SL_POSADA, SL_DATE, SL_NUMBER, SL_SYSTEM, SL_PRUMITKA 
          FROM UPR28.OLEG_SL_YDO_BLOK 
          WHERE REPLACE(UPPER(SL_PIB), ' ', '') = REPLACE(UPPER('$userPibWindows1251'), ' ', '')  order by sl_date desc";
}
*/


?>
