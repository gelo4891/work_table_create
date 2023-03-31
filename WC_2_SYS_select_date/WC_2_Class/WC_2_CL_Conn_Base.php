<?php
class WC_CL_Conn_Base {

		private $WCA_dbType;
		private $WCA_host;
		private $WCA_port;
		private $WCA_user;
		private $WCA_password;
		private $WCA_dbName;
		
	
		public function __construct($WCA_dbType = 'mysql', $WCA_host = 'localhost', 
        $WCA_port = 3306, $WCA_user = 'gelo4891',   $WCA_password = 'gelo1111', $WCA_dbName = 'base_o_zvit') {
            $this->WCA_dbType = $WCA_dbType;
            $this->WCA_host = $WCA_host;
            $this->WCA_port = $WCA_port;
            $this->WCA_user = $WCA_user;
            $this->WCA_password = $WCA_password;
            $this->WCA_dbName = $WCA_dbName;      
        }	

/*------------------------NEW-------connect Base PDO------GOOOOD-------------------------------*/
public function WC_CL_conn_base_func() {
    try {
        if ($this->WCA_dbType == 'mysql') {
            $dsn = "mysql:host={$this->WCA_host};dbname={$this->WCA_dbName}";
            if ($this->WCA_port) {
                $dsn .= ";port={$this->WCA_port}";
            }
            $conn = new PDO($dsn, $this->WCA_user, $this->WCA_password);
            return $conn;
        } elseif ($this->WCA_dbType == 'oracle') {
            $dsn = "oci:dbname={$this->WCA_host}:{$this->WCA_port}/{$this->WCA_dbName}";
            $conn= new PDO($dsn, $this->WCA_user, $this->WCA_password);
            return $conn;
        } else {
            throw new Exception('Invalid database type');
        }
    } catch (PDOException $e) {
        echo "Could not connect to database: " . $e->getMessage();
        return;
    }
}

    public function WC_CL_conn_disconnect_from_base() {
        $this->WCA_conn = null;
    }

    /*=====================================================================================================================*/
	/*---------------------------Query Sql-----------------------------------*/
    public function WC_CL_conn_query_sql($pdo, $boz_am_param=null, $sql="SELECT * FROM boz_am_parametrs where boz_am_param=") {
        if (!$pdo) {
            throw new Exception('Not connected to database');
        }
    
        $sql=$sql."'$boz_am_param'";
    
        $result = $pdo->query($sql);
        if (!$result) {
            throw new Exception($pdo->errorInfo()[2]);
        }
        if (strpos(strtolower($sql), 'select') === 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                throw new Exception('No rows returned');
            }
            $boz_am_znach = $row['boz_am_znach'];
            $boz_am_Server_root = $row['boz_am_Server_root'];
            if ($boz_am_Server_root == 1) {
                $boz_am_znach = $_SERVER['DOCUMENT_ROOT'] . $boz_am_znach;
            }
            if (strpos($boz_am_znach, 'array') !== false) {
                $boz_am_znach = str_replace(array('array(', ')', "'"), array('', '', ''), $boz_am_znach);
                $boz_am_znach = explode(',', $boz_am_znach);
            }
            return $boz_am_znach;
        } else {
            return $result->rowCount();
        }
    }

    
    
	/*--------------------------------END------------------------------------*/
/*=====================================================================================================================*/

    
	/*--------------------------------END----connect Base PDO--------------------------------*/
}
?>
