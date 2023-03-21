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
	
		public function __construct($WCA_dbType = 'mysql', $WCA_host = 'localhost', $WCA_port = 3306, $WCA_user = '', $WCA_password = '', $WCA_dbName = '', $WCA_table = '') {
            $this->WCA_dbType = $WCA_dbType;
            $this->WCA_host = $WCA_host;
            $this->WCA_port = $WCA_port;
            $this->WCA_user = $WCA_user;
            $this->WCA_password = $WCA_password;
            $this->WCA_dbName = $WCA_dbName;
            $this->WCA_WCA_table= $WCA_table;
        }
	/*-----------------------------OLD--connect Base Oracle or MySQL-------------------------------------*/
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
	/*--------------------------------END-----connect Base Oracle or MySQL-------------------------------*/

/*=====================================================================================================================*/

/*-------------------------------------create button-------------------------------*/
public function WC_1_createButtons_text_json($buttonDataUrl, $containerClass) {
    $buttonsData = file_get_contents($buttonDataUrl);
    $buttonsData = json_decode($buttonsData, true);
    $buttonsContainer = "<div class='$containerClass'>";
    foreach ($buttonsData as $buttonData) {
        $button = "<button>";
        $button .= "<a href='" . $buttonData["link"] . "' target='_blank' title='". $buttonData["title"] ."'><span class='comment'>" . $buttonData["nazve_knopku"] . "</span></a>";
        $button .= "</button>";
        $buttonsContainer .= $button;
    }
    $buttonsContainer .= "</div>";
    echo $buttonsContainer;
}

public function WC_1_createButtons_php($buttonDataFile, $containerClass) {
    $buttonsData = include($buttonDataFile);
    $buttonsContainer = "<div class='$containerClass'>";
    foreach ($buttonsData as $buttonData) {
        $button = "<button>";
        $button .= "<a href='" . $buttonData["link"] . "' target='_blank' title='". $buttonData["title"] ."'><span class='comment'>" . $buttonData["nazve_knopku"] . "</span></a>";
        $button .= "</button>";
        $buttonsContainer .= $button;
    }
    $buttonsContainer .= "</div>";
    echo $buttonsContainer;
}
/*--------------------------------END-----create button-------------------------------*/

/*=====================================================================================================================*/
/*-------------------------------------create bmenu-------------------------------*/
public function WC_generateMenu($menuData, $containerClass, $level = 0) {
    $menuContainer = "<ul class='$containerClass'>";

    foreach ($menuData as $menuItem) {
        $menu = "<li>";
        $menuLink = "<a href='" . $menuItem["link"] . "' target='_blank'>" . $menuItem["title"] . "</a>";
        $menu .= $menuLink;

        // Check if sub-menu exists
        if (isset($menuItem["submenu"]) && !empty($menuItem["submenu"])) {
            // Generate sub-menu recursively
            $menu .= $this->WC_generateMenu($menuItem["submenu"], "", $level + 1);
        }

        $menu .= "</li>";
        $menuContainer .= $menu;
    }

    $menuContainer .= "</ul>";

    return $menuContainer;
}


/*--------------------------------------------------------------------------------*/
public function WC_generateMenu_3($menuData, $containerClass, $menuAttrs = [], $level = 0, $isSubmenu = false) {
    $menuContainerAttrs = $this->WC_generateAttrs($menuAttrs);
    $menuContainer = "";

    // Add class for main menu container
    if (!$isSubmenu) {
        $menuContainer .= "<ul class='$containerClass' $menuContainerAttrs>";
    } else {
        $menuContainer .= "<ul class='submenu' $menuContainerAttrs>";
    }

    foreach ($menuData as $menuItem) {
        $menuItemAttrs = isset($menuItem["attrs"]) ? $this->WC_generateAttrs($menuItem["attrs"]) : "";
        $menu = "<li $menuItemAttrs>";
        $menuLinkAttrs = $this->WC_generateAttrs([
            "href" => $menuItem["link"],
            "target" => isset($menuItem["target"]) ? $menuItem["target"] : ""
        ]);
        $menuLink = "<a $menuLinkAttrs>" . $menuItem["title"] . "</a>";
        $menu .= $menuLink;

        // Check if sub-menu exists
        if (isset($menuItem["submenu"]) && !empty($menuItem["submenu"])) {
            // Generate sub-menu recursively and add class for sub-menu container
            $menu .= $this->WC_generateMenu_3($menuItem["submenu"], "", [], $level + 1, true);
        }
        $menu .= "</li>";
        $menuContainer .= $menu;
    }

    $menuContainer .= "</ul>";
    return $menuContainer;
}

private function WC_generateAttrs($attrs) {
    $attributes = "";
    foreach ($attrs as $attr => $value) {
        $attributes .= " $attr='$value'";
    }
    return $attributes;
}
/*--------------------------------------------------------------------------------*/
/*--формування меню з двома параметрами 1-назва меню, 2-посилання взятих із полів -*/
public function WC_generateMenu_4($menuData, $containerClass, $accessLevel,$BOZ_AccessLevel,$http_blank='_blank', $level = 0, $isSubmenu = false) {

    $menuContainer = "";

    // Add class for main menu container
    if (!$isSubmenu) {
        $menuContainer .= "<ul class='$containerClass'>";
    } else {
        $menuContainer .= "<ul class='submenu'>";
    }    
    foreach ($menuData as $menuItem) {
            // Check if the menu item should be displayed based on the access level
        if (isset($menuItem["$BOZ_AccessLevel"]) && $menuItem["$BOZ_AccessLevel"] > $accessLevel) {
            continue;            
        }       
      
        //echo $path = 'http://' . $_SERVER['HTTP_HOST'] . '/' . basename($_SERVER['DOCUMENT_ROOT']) . $menuItem["link"] ;
        $menu = "<li class='tesssssssss' >";


        if (strtolower(substr($menuItem["link"], 0, 4)) === 'http') {
            // виконується коли перші чотири символи рядка рівні 'http'
            echo ('test');
            $menuLink=' 0';
        } else {
            // виконується коли перші чотири символи рядка не рівні 'http'
            $menuLink = "<a href='" . 'http://' . $_SERVER['HTTP_HOST'] . '/' .  $menuItem["link"] . "' target='".$http_blank."'>" . $menuItem["title"] . "</a>";
        }
        
        
        $menu .= $menuLink;

        // Check if sub-menu exists
        if (isset($menuItem["submenu"]) && !empty($menuItem["submenu"])) {
            // Generate sub-menu recursively and add class for sub-menu container
            $menu .= $this->WC_generateMenu_4($menuItem["submenu"], "", $accessLevel, $level + 1, true);
        }
        $menu .= "</li>";
        $menuContainer .= $menu;
    }

    $menuContainer .= "</ul>";
    return $menuContainer;
}



/*--------------------------------------------------------------------------------*/
/*
public function WC_generateMenu_2($menuData_1, $containerClass, $submenuClass) {
    $menuContainer = "<ul class='$containerClass'>";

    foreach ($menuData_1 as $menuItem) {
        $menu = "<li>";
        $menuLinkAttrs = "href='" . $menuItem["link"] . "'";

        // Check if submenu exists and is not empty
        if (is_array($menuItem["submenu"]) && count($menuItem["submenu"]) > 0) {
            $menuLinkAttrs .= " class='$submenuClass'";
        }

        $menuLink = "<a $menuLinkAttrs>" . $menuItem["title"] . "</a>";
        $menu .= $menuLink;

        // Generate submenu recursively if it exists and is not empty
        if (is_array($menuItem["submenu"]) && count($menuItem["submenu"]) > 0) {
            $menu .= $this->WC_generateMenu_2($menuItem["submenu"], "", $submenuClass);
        }

        $menu .= "</li>";
        $menuContainer .= $menu;
    }

    $menuContainer .= "</ul>";

    echo $menuContainer;
}
*/
/*--------------------------------END-----create menu-------------------------------*/
  
/*=====================================================================================================================*/
	/*------------------------OLD-------connect Base PDO-------------------------------------*/
  public function WC_connect_to_base_PDO1() {
        $WCA_PDO_dsn = "{$this->WCA_PDO_dbType}:dbname={$this->WCA_PDO_dbName};host={$this->WCA_PDO_host};port={$this->WCA_PDO_port};charset=utf8mb4";
        $WCA_PDO_options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        );
        try {
            $this->WCA_PDO_conn = new PDO($WCA_PDO_dsn, $this->WCA_PDO_user, $this->WCA_PDO_password, $WCA_PDO_options);
        } catch (PDOException $e) {
            throw new Exception('Could not connect to database: ' . $e->getMessage());
        }
        return $this->WCA_PDO_conn;
    }

/*------------------------NEW-------connect Base PDO------GOOOOD-------------------------------*/
public function WC_connect_to_base_PDO($dbType, $host, $dbName, $user, $password, $port = null) {
    try {
        if ($dbType == 'mysql') {
            $dsn = "mysql:host={$host};dbname={$dbName}";
            if ($port) {
                $dsn .= ";port={$port}";
            }
            $conn = new PDO($dsn, $user, $password);
            return $conn;
        } elseif ($dbType == 'oracle') {
            $dsn = "oci:dbname={$host}:{$port}/{$dbName}";
            $conn= new PDO($dsn, $user, $password);
            return $conn;
        } else {
            throw new Exception('Invalid database type');
        }
    } catch (PDOException $e) {
        echo "Could not connect to database: " . $e->getMessage();
        return;
    }
}

    public function WC_disconnect_from_base() {
        $this->WCA_conn = null;
    }
    
	/*--------------------------------END----connect Base PDO--------------------------------*/
/*=====================================================================================================================*/
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
/*=====================================================================================================================*/
	/*---------------------------Query Sql-----------------------------------*/
    public function WC_query_sql($pdo, $sql) {
        if (!$pdo) {
            throw new Exception('Not connected to database');
        }
        $result = $pdo->query($sql);
        if (!$result) {
            throw new Exception($pdo->errorInfo()[2]);
        }
        if (strpos(strtolower($sql), 'select') === 0) {
            $rows = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return $result->rowCount();
        }
    }
	/*--------------------------------END------------------------------------*/
/*=====================================================================================================================*/
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
/*=====================================================================================================================*/
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

public function WC_buildQuery_MySql($table, $data = array(), $conditions = array(), $orderBy = '', $limit = '') {
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
/*--------------------------------END------------------------------------*/
/*=====================================================================================================================*/


static function WC_2_JS_PutToDiv($div_name,$class_name) {
    echo '<script src="/jQuery/jquery-3.6.4.js"></script>
          <script>
          $(document).ready(function() {
              // Обробник події при кліку на елемент меню
              $(".'.$class_name.'").on("click", function(event) {
                  event.preventDefault();
                  // Отримуємо адресу сторінки, яку потрібно відобразити у правому div-елементі
                  var pageUrl = $(this).attr("href");
                  // Виконуємо AJAX-запит і вставляємо відповідь у правий div-елемент
                  $("#'.$div_name.'").load(pageUrl);
              });
          });
          </script>';
  }




	}
/*--------------------------------END------------------------------------*/
/*=====================================================================================================================*/

//echo "<br> -----====== file conect WC_2_all_class.php ===---------<br>";
?>
