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
    case 'PIB_ALL':
                return "SELECT
                ROWID,
                SL_PIB,
                SL_IND,
                SL_NAME_PIDROZDIL,
                SL_POSADA,
                TO_CHAR(SL_DATE, 'DD.MM.YYYY') AS SL_DATE,
                SL_NUMBER,
                SL_SYSTEM,
                SL_PRUMITKA
            FROM
                UPR28.OLEG_SL_YDO_BLOK
            ORDER BY SL_IND";
               break;
/*------------------------------------------------------------------------------------------------*/
     
               case 'DATE_UPDATE':
                  
               /* return "UPDATE UPR28.OLEG_SL_YDO_BLOK
                        SET 
                            SL_DATE = TO_DATE('$param', 'YYYY-MM-DD'), 
                            SL_NUMBER = :SL_NUMBER, 
                            SL_PRUMITKA = :SL_PRUMITKA
                            WHERE rowid = :SL_ROW";    */
              return "UPDATE UPR28.OLEG_SL_YDO_BLOK
                             SET 
                                 SL_DATE = :SL_DATE, 
                                 SL_NUMBER = :SL_NUMBER, 
                                 SL_PRUMITKA = :SL_PRUMITKA
                                 WHERE rowid = :SL_ROW";                              

            break;
/*------------------------------------------------------------------------------------------------*/         
            case 'PIB_UPDATE_INFO':
                return "SELECT
                    ROWID,
                    SL_PIB,
                    SL_IND,
                    SL_NAME_PIDROZDIL,
                    SL_POSADA,
                    TO_CHAR(SL_DATE, 'DD.MM.YYYY') AS SL_DATE,
                    SL_NUMBER,
                    SL_SYSTEM,
                    SL_PRUMITKA
                FROM
                    UPR28.OLEG_SL_YDO_BLOK
                    WHERE rowid='$param'";
                break;
/*------------------------------------------------------------------------------------------------*/   
    default:
          // Handle unknown type
          return "";
  }
}

?>
