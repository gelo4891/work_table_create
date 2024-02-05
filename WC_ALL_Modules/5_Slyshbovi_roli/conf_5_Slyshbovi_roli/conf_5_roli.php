<?php

/*===================================================================== */
/*require_once ($_SERVER['DOCUMENT_ROOT'] .'/session/WC_2_check_sesion.php');
$session_checker1 = new SessionChecker();
$chek_auh=$session_checker1->WC_Auth_check_session(false,'/WC_2_SYS_select_date/WC_2_start.php');

/**===================================================================== */


$dbDsn = 'odbc:ODBS_dell720';
$dbUser = 'upr28';
$dbPass = 'upr28';   

function getQueryByType($type, $param = null) {
  switch ($type) {
      case 'PIB':
          return "SELECT 
                      IP_SHTAT_MONTH, IP_SHTAT_INDEX, IP_SHTAT_PIB,  
                      IP_SHTAT_NAME_PIDR, IP_SHTAT_POSADA, IP_SHTAT_NAPRYAM
                  FROM 
                      UPR28.IP_2021_SHTAT
                  WHERE 
                      IP_SHTAT_MONTH = (SELECT DISTINCT(MAX(IP_SHTAT_MONTH)) FROM UPR28.IP_2021_SHTAT )
                  ORDER BY 
                      IP_SHTAT_PIB";
         
      case 'PIB_ALL':
          $userPibWindows1251 = iconv('UTF-8', 'WINDOWS-1251', $param);
          return "SELECT 
                      SL_PIB, SL_IND, SL_NAME_PIDROZDIL, 
                      SL_POSADA, SL_DATE, SL_NUMBER, SL_SYSTEM, SL_PRUMITKA 
                  FROM 
                      UPR28.OLEG_SL_YDO_BLOK 
                  WHERE 
                      REPLACE(UPPER(SL_PIB), ' ', '') = REPLACE(UPPER('$userPibWindows1251'), ' ', '')  
                  ORDER BY 
                      sl_date DESC";
      
      case 'PIB_DATE':
          $userPibWindows1251 = iconv('UTF-8', 'WINDOWS-1251', $param);
          //$userPibWindows1251 =  $param;
          return "SELECT 
                      IP_SHTAT_MONTH, 
                      IP_SHTAT_INDEX, 
                      IP_SHTAT_PIB, 
                      IP_SHTAT_NAME_PIDR, 
                      IP_SHTAT_POSADA, 
                      TO_CHAR(IP_STAT_DATE_START, 'YYYY-MM-DD') AS IP_STAT_DATE_START
                  FROM 
                      UPR28.IP_2021_SHTAT
                  WHERE 
                      IP_SHTAT_MONTH = (SELECT DISTINCT(MAX(IP_SHTAT_MONTH)) FROM UPR28.IP_2021_SHTAT)
                      AND REPLACE(UPPER(IP_SHTAT_PIB), ' ', '') = REPLACE(UPPER('$userPibWindows1251'), ' ', '')";
      
      default:
          // Handle unknown type
          return "";
  }
}

?>
