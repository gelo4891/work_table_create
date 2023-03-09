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
			$this->WCA_dbType = $WCA_dbType;
			$this->WCA_host = $WCA_host;
			$this->WCA_port = $WCA_port;
			$this->WCA_user = $WCA_user;
			$this->WCA_password = $WCA_password;
			$this->WCA_dbName = $WCA_dbName;
			$this->WCA_WCA_table= $WCA_table;
		}
	/*-------------------------------connect Base Oracle or MySQL-------------------------------------*/
        public function WC_connect_to_base() {
        if ($this->WCA_dbType == 'mysql') {
            $this->WCA_conn = mysqli_connect($this->WCA_host, $this->WCA_user, $this->WCA_password, $this->WCA_dbName, $this->WCA_port);
        } elseif ($this->WCA_dbType == 'oracle') {
            $this->WCA_conn= oci_connect($this->WCA_user, $this->WCA_password, "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = $this->WCA_host)(PORT = $this->WCA_port)))(CONNECT_DATA=(SID=$this->WCA_dbName)))");
        }
        if (!$this->WCA_conn) {
            throw new Exception('Could not connect to database');
        }
        return $this->WCA_conn;
    }
	/*--------------------------------END------------------------------------*/


    	/*---------------------------Create SQL_Query-----------------------------*/

        public function WC_buildWhereClause($WC_Array_data_Where, $WC_logicOperator = 'AND') {
            $WC_where = array();
            foreach ($WC_Array_data_Where as $WC_field => $WC_value) {
                if (is_array($WC_value)) {
                    if (count($WC_value) == 2 && strtoupper($WC_value[0]) == 'IN') {
                        // Handle subquery in the IN clause
                        $subquery = $WC_value[1];
                        $WC_where[] = "$WC_field (" . (is_string($subquery) ? $subquery : $this->WC_buildQuery(...$subquery)) . ")";
                    } else {
                        $WC_where[] = "$WC_field " . implode(' ', $WC_value);
                    }
                } else {
                    $WC_where[] = "$WC_field = '$WC_value'";
                }
            }
            return implode(" $WC_logicOperator ", $WC_where);
        }



    public function WC_2_buildQuery($WC_Tup_Zaputy, $WC_Name_Table, $WC_Array_data_insert = array(), $WC_Array_data_Where = array(), $WC_orderBy = '', $WC_limit = '', $WC_logicOperator = 'AND')
    {
        switch(strtolower($WC_Tup_Zaputy)) {
            case 'select':
                $WC_fields = isset($WC_Array_data_insert['fields']) ? $WC_Array_data_insert['fields'] : '*';
                $WC_query = "SELECT $WC_fields FROM $WC_Name_Table";
                break;

            case 'insert':
                $WC_fields = implode(',', array_keys($WC_Array_data_insert));
                $WC_values = "'" . implode("','", array_values($WC_Array_data_insert)) . "'";
                $WC_query = "INSERT INTO $WC_Name_Table ($WC_fields) VALUES ($WC_values)";
                break;

            case 'update':
                $WC_set = array();
                foreach($WC_Array_data_insert as $WC_field => $WC_value) {
                    if(is_array($WC_value)) {
                        $WC_set[] = "$WC_field " . implode(' ', $WC_value);
                    } else {
                        $WC_set[] = "$WC_field = '$WC_value'";
                    }
                }
                $WC_set = implode(',', $WC_set);
                $WC_where = $WC_Array_data_Where ? ' WHERE ' . $this->WC_buildWhereClause($WC_Array_data_Where, $WC_logicOperator) : '';
                $WC_query = "UPDATE $WC_Name_Table SET $WC_set$WC_where";
                break;

            case 'delete':
                $WC_where = $WC_Array_data_Where ? ' WHERE ' . $this->WC_buildWhereClause($WC_Array_data_Where, $WC_logicOperator) : '';
                $WC_query = "DELETE FROM $WC_Name_Table$WC_where";
                break;

            case 'merge':
                $WC_fields = implode(',', array_keys($WC_Array_data_insert));
                $WC_values = "'" . implode("','", array_values($WC_Array_data_insert)) . "'";
                $WC_update = array();
                foreach($WC_Array_data_insert as $WC_field => $WC_value) {
                    $WC_update[] = "$WC_field = VALUES($WC_field)";
                }
                $WC_update = implode(',', $WC_update);
                $WC_query = "INSERT INTO $WC_Name_Table ($WC_fields) VALUES ($WC_values) ON DUPLICATE KEY UPDATE $WC_update";
                break;

            default:
                throw new Exception('Unsupported query type');
        }

        if(!empty($WC_orderBy)) {
            $WC_query .= " ORDER BY $WC_orderBy";
        }
        if(!empty($WC_limit)) {
            $WC_query .= " LIMIT $WC_limit";
        }

        return $WC_query;
    }
	/*--------------------------------END------------------------------------*/

	/*---------------------------Query Sql-----------------------------------*/
		public function WC_query_sql($sql) {
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
		public function WC_BuildTable($BT_data,$BT_class_Name) {
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
/*--------------------------------END------------------------------------*/

/*-------------------------------Create QUERY SQL-------------------------------------*/
public function WC_buildQuery_system($dbType, $table, $data = array(), $conditions = array(), $orderBy = '', $limit = '') {
    switch(strtolower($dbType)) {
        case 'mysql':
            return $this->WC_buildQuery_MySql($table, $data, $conditions, $orderBy, $limit);
            break;

        case 'oracle':
            return $this->WC_buildQuery_Oracle($table, $data, $conditions, $orderBy, $limit);
            break;

        default:
            throw new Exception('Unsupported query type');
            break;
    }
}

private function WC_buildQuery_MySql($table, $data = array(), $conditions = array(), $orderBy = '', $limit = '') {
    $queryType = 'SELECT';
    $selectFields = isset($data['fields']) ? $data['fields'] : '*';
    $insertFields = implode(',', array_keys($data));
    $insertValues = "'" . implode("','", array_values($data)) . "'";
    $updateFields = array();
    foreach($data as $field => $value) {
        $updateFields[] = "$field = '$value'";
    }
    $updateFields = implode(',', $updateFields);

    $whereConditions = array();
    foreach($conditions as $field => $value) {
        $whereConditions[] = "$field = '$value'";
    }
    $whereClause = !empty($whereConditions) ? "WHERE " . implode(' AND ', $whereConditions) : '';

    $orderByClause = !empty($orderBy) ? "ORDER BY $orderBy" : '';
    $limitClause = !empty($limit) ? "LIMIT $limit" : '';

    if(!empty($conditions) && !empty($data)) {
        $queryType = 'UPDATE';
        $query = "UPDATE $table SET $updateFields $whereClause";
    } elseif(!empty($data)) {
        $queryType = 'INSERT';
        $query = "INSERT INTO $table ($insertFields) VALUES ($insertValues)";
    } elseif(!empty($conditions)) {
        $queryType = 'DELETE';
        $query = "DELETE FROM $table $whereClause";
    } else {
        $query = "SELECT $selectFields FROM $table $whereClause $orderByClause $limitClause";
    }
    return $query;
}


	}
/*--------------------------------END------------------------------------*/


//echo "<br> -----====== file conect WC_2_all_class.php ===---------<br>";
?>
