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
return "WITH RankedResults AS (
  SELECT 
    a.IP_SHTAT_PIB AS A_IP_SHTAT_PIB, 
    a.IP_SHTAT_INDEX AS A_IP_SHTAT_INDEX, 
    a.IP_SHTAT_NAME_PIDR AS A_IP_SHTAT_NAME_PIDR, 
    a.IP_SHTAT_POSADA AS A_IP_SHTAT_POSADA,  
    a.IP_SHTAT_MONTH AS A_IP_SHTAT_MONTH,
    ROW_NUMBER() OVER (PARTITION BY a.IP_SHTAT_PIB ORDER BY a.IP_SHTAT_MONTH DESC) AS rn
  FROM IP_2021_SHTAT a
  LEFT JOIN IP_2021_SHTAT b 
    ON a.IP_SHTAT_PIB = b.IP_SHTAT_PIB
    AND b.IP_SHTAT_MONTH = $placeholders
  WHERE b.IP_SHTAT_PIB IS NULL
)
SELECT 
  A_IP_SHTAT_PIB, 
  A_IP_SHTAT_INDEX, 
  A_IP_SHTAT_NAME_PIDR, 
  A_IP_SHTAT_POSADA,  
  A_IP_SHTAT_MONTH
FROM RankedResults
WHERE rn = 1";
}

  
?>
