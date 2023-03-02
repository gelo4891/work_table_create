<?php
class WorkClassAll {

		private $WCA_dbType;
		private $WCA_host;
		private $WCA_port;
		private $WCA_user;
		private $WCA_password;
		private $WCA_dbName;
		private $WCA_conn;
		private $BT_class_Name;
		private	$WCA_table;
		
	
		public function __construct($WCA_dbType, $WCA_host, $WCA_port, $WCA_user, $WCA_password, $WCA_dbName, $WCA_table) {
			$this->dbType = $WCA_dbType;
			$this->host = $WCA_host;
			$this->port = $WCA_port;
			$this->user = $WCA_user;
			$this->password = $WCA_password;
			$this->dbName = $WCA_dbName;
			$this->WCA_table= $WCA_table;
		}
	/*-------------------------------connect Base Oracle or MySQL-------------------------------------*/
		public function WCA_connect_to_base() {
			if ($this->dbType == 'mysql') {
				$this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->dbName, $this->port);
			} elseif ($this->dbType == 'oracle') {
				$this->conn = oci_connect($this->user, $this->password, "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = $this->host)(PORT = $this->port)))(CONNECT_DATA=(SID=$this->dbName)))");
			}
			if (!$this->conn) {
				throw new Exception('Could not connect to database');
			}
		}
	/*--------------------------------END------------------------------------*/

	/*---------------------------Create SQL_Query-----------------------------*/
	public function WCA_buildQuery($WCA_dbType, $WCA_table, $data = array(), $conditions = array(), $orderBy = '', $limit = '')
    {
        switch(strtolower($WCA_dbType)) {
            case 'select':
                $fields = isset($data['fields']) ? $data['fields'] : '*';
                $query = "SELECT $fields FROM $WCA_table";
                break;

            case 'insert':
                $fields = implode(',', array_keys($data));
                $values = "'" . implode("','", array_values($data)) . "'";
                $query = "INSERT INTO $WCA_table ($fields) VALUES ($values)";
                break;

            case 'update':
                $set = array();
                foreach($data as $field => $value) {
                    $set[] = "$field = '$value'";
                }
                $set = implode(',', $set);
                $query = "UPDATE $WCA_table SET $set";
                break;

            case 'delete':
                $query = "DELETE FROM $WCA_table";
                break;

            case 'merge':
                $fields = implode(',', array_keys($data));
                $values = "'" . implode("','", array_values($data)) . "'";
                $update = array();
                foreach($data as $field => $value) {
                    $update[] = "$field = VALUES($field)";
                }
                $update = implode(',', $update);
                $query = "INSERT INTO $WCA_table ($fields) VALUES ($values) ON DUPLICATE KEY UPDATE $update";
                break;
            default:
                throw new Exception('Unsupported query type');
        }
        if(!empty($conditions)) {
            $where = array();
            foreach($conditions as $field => $value) {
                $where[] = "$field = '$value'";
            }
            $where = implode(' AND ', $where);
            $query .= " WHERE $where";
        }
        if(!empty($orderBy)) {
            $query .= " ORDER BY $orderBy";
        }
        if(!empty($limit)) {
            $query .= " LIMIT $limit";
        }
        return $query;
    }
	/*--------------------------------END------------------------------------*/

	/*---------------------------Query Sql-----------------------------------*/
		public function WCA_query_sql($sql) {
			if (!$this->conn) {
				throw new Exception('Not connected to database');
			}
			$result = mysqli_query($this->conn, $sql);
			if (!$result) {
				throw new Exception(mysqli_error($this->conn));
			}
			if (strpos(strtolower($sql), 'select') === 0) {
				$rows = array();
				while ($row = mysqli_fetch_assoc($result)) {
					$rows[] = $row;
				}
				return $rows;
			} else {
				return mysqli_affected_rows($this->conn);
			}
		}
	/*--------------------------------END------------------------------------*/

	/*----------------------------Bild Table----------------------------------------*/
		public function WCA_BuildTable($BT_data,$BT_class_Name) {
			if (empty($BT_data)) {
				throw new Exception('No data provided to build table');
			}
			$html = '<table class='.$BT_class_Name.'>';
			$html .= '<thead><tr>';
			foreach ($BT_data[0] as $key => $value) {
				$html .= '<th>' . $key . '</th>';
			}
			$html .= '</tr></thead>';
			$html .= '<tbody>';
			foreach ($BT_data as $row) {
				$html .= '<tr>';
				foreach ($row as $key => $value) {
					$html .= '<td>' . $value . '</td>';
				}
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
			return $html;
		}
	}
/*--------------------------------END------------------------------------*/

?>
