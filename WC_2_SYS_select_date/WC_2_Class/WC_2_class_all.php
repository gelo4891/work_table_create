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
       // private $fileInput;
       // private $submitBtn;
	
		public function __construct($WCA_dbType = 'mysql', $WCA_host = 'localhost', $WCA_port = 3306, $WCA_user = '',
         $WCA_password = '', $WCA_dbName = '', $WCA_table = '', $fileInput='', $submitBtn='') {
            $this->WCA_dbType = $WCA_dbType;
            $this->WCA_host = $WCA_host;
            $this->WCA_port = $WCA_port;
            $this->WCA_user = $WCA_user;
            $this->WCA_password = $WCA_password;
            $this->WCA_dbName = $WCA_dbName;
            $this->WCA_WCA_table= $WCA_table;
          //  $this->fileInput = document.querySelector('input[type="'.$fileInputName.'"]');
          //  $this->submitBtn = document.querySelector('input[type="'.$submitBtnName.'"]');
        
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




/*---------------GOOOD-----------------------------*/
public function WC_generateMenu_5($menuData,$JS_class_menu='JS_class_menu') {
    // Initialize variables for tracking menu level
    $currentMenuId = null;
    $currentSubMenuId = null;
    $currentMenuLevel = 0;
  
    // Start building the menu HTML
    $menuHTML = '<ul>';
  
    // Loop through each row of the menu data
    foreach ($menuData as $row) {
      // Check if this row is a new menu item
      if ($row['has_submenu'] == 0) {
        // If we were previously building a sub-menu, close it out
        if ($currentSubMenuId !== null) {
          $menuHTML .= '</ul></li>';
          $currentSubMenuId = null;
        }
  
        // Check if we're starting a new top-level menu item
        if ($row['id'] !== $currentMenuId) {
          // If we were previously building a top-level menu item, close it out
          if ($currentMenuId !== null) {
            $menuHTML .= '</li>';
          }
  
          // Start a new top-level menu item
          $menuHTML .= '<li><a href="' . $row['link'] . '" class="'.$JS_class_menu.'" >' . $row['title'] . '</a>';
          $currentMenuId = $row['id'];
          $currentMenuLevel = 0;
        }
      }

      if ($currentMenuLevel == 0) {
        $menuHTML .= '</li>';
      }
  
      // Check if this row is a sub-menu item
      if ($row['has_submenu'] == 1) {
        // Check if we're starting a new sub-menu
        if ($row['id'] !== $currentSubMenuId) {
          // If we were previously building a sub-menu, close it out
          if ($currentSubMenuId !== null) {
            $menuHTML .= '</ul></li>';
          }
      
          // Start a new sub-menu
          $menuHTML .= '<li><a href="' . $row['link'] . '" class="'.$JS_class_menu.'">' . $row['title'] . '</a><ul>';
          $currentSubMenuId = $row['menu_id'];
          $currentMenuLevel = 1;
        }
      }

      if ($row['has_submenu'] == 0 && $currentSubMenuId !== null) {
        // If we were previously building a sub-menu, close it out
        $menuHTML .= '</ul></li>';
        $currentSubMenuId = null;
      }

      
  
      // If this row is neither a top-level menu item nor a sub-menu item, skip it
      if ($row['has_submenu'] != 0 && $row['has_submenu'] != 1) {
        continue;
      }
  
      // Add the current row's sub-menu item to the current sub-menu
      if ($currentSubMenuId !== null && $currentMenuLevel == 1) {
        $menuHTML .= '<li tabindex="0"><a href="' . $row['sub_link'] . '" class="'.$JS_class_menu.'">' . $row['sub_title'] . '</a></li>';
      }
    }
  
    // Close out any open sub-menu or top-level menu item
    if ($currentSubMenuId !== null) {
      $menuHTML .= '</ul></li>';
    }

    if ($currentMenuId !== null) {

      $menuHTML .= '</ul></li>';
    }
    $menuHTML .= '</ul>';
    
    // Return the completed menu HTML
    return $menuHTML;
    }



/*------------------------Create menu as KnpMenu--------------------------------------------------------*/

public function WC_generateMenu_6_KnpMenu(array $menuData, FactoryInterface $factory): string
{
    $menu = $factory->createItem('root');

    // Loop through each row of the menu data
    foreach ($menuData as $row) {
        // Check if this row is a new menu item
        if ($row['has_submenu'] == 0) {
            $menu->addChild($row['title'], ['uri' => $row['link']]);
        }

        // Check if this row is a sub-menu item
        if ($row['has_submenu'] == 1) {
            $menu[$row['title']]->addChild($row['sub_title'], ['uri' => $row['sub_link']]);
        }
    }

    return $menu->render('knp_menu.html.twig', [
        'currentClass' => 'active',
    ]);
}

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

    /*
        echo "<pre>";
echo $stmt->queryString;
echo "</pre>";*/


public function WC_query_sql2($pdo, $sql, $params) {
    if (!$pdo) {
        throw new Exception('Not connected to database');
    }
    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindParam($key, $value);
    }
    $stmt->execute();
    if (strpos(strtolower($sql), 'select') === 0) {
        $rows = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    } else {
        return $stmt->rowCount();
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



public function WC_buildQuery_MySql2($table, $WC_data = array(), $WC_conditions = array(), $WC_groupBy = '', $WC_having = '', $WC_join = '', $WC_orderBy = '', $WC_limit = '') {
    // Select Fields
    if(!empty($WC_data)) {
        $selectFields = $WC_data['fields'];
    } else {
        $selectFields = '*';
    }

    // Where Clause
    $whereClause = '';
    if(!empty($WC_conditions)) {
        $whereClause = ' WHERE ';
        $conditions = array();
        foreach($WC_conditions as $key => $value) {
            $conditions[] = "$key = '$value'";
        }
        $whereClause .= implode(' AND ', $conditions);
    }

    // Group By Clause
    $groupByClause = '';
    if(!empty($WC_groupBy)) {
        $groupByClause = ' GROUP BY ' . $WC_groupBy;
    }

    // Having Clause
    $havingClause = '';
    if(!empty($WC_having)) {
        $havingClause = ' HAVING ' . $WC_having;
    }

    // Join Clause
    $joinClause = '';
    if(!empty($WC_join)) {
        $joinClause = ' ' . $WC_join;
    }

    // Order By Clause
    $orderByClause = '';
    if(!empty($WC_orderBy)) {
        $orderByClause = ' ORDER BY ' . $WC_orderBy;
    }

    // Limit Clause
    $limitClause = '';
    if(!empty($WC_limit)) {
        $limitClause = ' LIMIT ' . $WC_limit;
    }

    // Query Type
    $queryType = 'SELECT';
    if(empty($WC_data) && empty($WC_conditions)){
        $queryType = 'SELECT';
    }
    // Query
    $query = "SELECT $selectFields FROM $table $joinClause $whereClause $groupByClause $havingClause $orderByClause $limitClause";

    // Check if query should be an INSERT or UPDATE
    if (!empty($WC_data)) {
        if (!empty($WC_conditions)) {
            $queryType = 'UPDATE';
            // Update Fields and Query for UPDATE Query Type
        $updateFields = '';
        if ($queryType == 'UPDATE') {
        foreach ($WC_data as $key => $value) {
        if ($key == 'fields') {
        continue;
        }
        $updateFields .= "$key = '$value', ";
        }
        $updateFields = rtrim($updateFields, ', ');
        $query = "UPDATE $table SET $updateFields $whereClause";
    }
        // Insert Fields and Query for INSERT Query Type
    $insertFields = '';
    $insertValues = '';
    if ($queryType == 'INSERT') {
        foreach ($WC_data as $key => $value) {
    if ($key == 'fields') {
    continue;
    }
    $insertFields .= "$key, ";
    $insertValues .= "'$value', ";
    }
    $insertFields = rtrim($insertFields, ', ');
    $insertValues = rtrim($insertValues, ', ');
    $query = "INSERT INTO $table ($insertFields) VALUES ($insertValues)";
    }
    // Return the Query
    return $query;
    }
}
}
    

/*--------------------------------END------------------------------------*/
/*=====================================================================================================================*/


public static function WC_2_JS_PutToDiv($class_name,$div_name) {

    echo '<script src="/jQuery/jquery-3.6.4.js"></script>
          <script>
          $(document).ready(function() {
              // Обробник події при кліку на елемент меню
              $(".'.$class_name.' a").on("click", function(event) {
                  event.preventDefault();
                  // Отримуємо адресу сторінки, яку потрібно відобразити у правому div-елементі
                  var pageUrl = $(this).attr("href");
                  // Виконуємо AJAX-запит і вставляємо відповідь у правий div-елемент
                  $(".'.$div_name.'").load(pageUrl);
              });
          });
          </script>';
}

public static function WC_2_JS_PutToDiv1($class_name,$div_name) {
    echo 'C_2_JS_PutToDiv1'; 
    echo '<script src="/jQuery/jquery-3.6.4.js"></script>
          <script>
          $(document).ready(function() {
              // Обробник події при кліку на елемент меню
              $(".'.$class_name.' a").on("click", function(event) {
                  event.preventDefault();
                  // Отримуємо адресу сторінки, яку потрібно відобразити у правому div-елементі
                  var pageUrl = $(this).attr("href");
                  // Виконуємо AJAX-запит і вставляємо відповідь у правий div-елемент
                  $(".'.$div_name.'").load(pageUrl);
              });
          });
          </script>';
}


public static function WC_2_JS_PutToDiv2($class_name,$div_name) {
    echo '<script src="/jQuery/jquery-3.6.4.js"></script>
          <script>
          $(document).ready(function() {
              // Обробник події при кліку на елемент меню
              $(".'.$class_name.' a").on("click", function(event) {
                  event.preventDefault();
                  // Отримуємо адресу сторінки, яку потрібно відобразити у правому div-елементі
                  var pageUrl = $(this).attr("href");
                  // Виконуємо AJAX-запит і вставляємо відповідь у правий div-елемент
                  $(".'.$div_name.'").load(pageUrl, function() {
                      // Додаємо обробник подій на всі посилання в елементі WC_2_menu_create_content
                      $(".'.$div_name.'").on("click", "a", function(event) {
                          event.preventDefault();
                          var pageUrl = $(this).attr("href");
                          $(".'.$div_name.'").load(pageUrl);
                      });
                  });
              });
          });
          </script>';
  }

  public static function WC_2_JS_EXIT($buttonId)
  {
      echo '<script src="/jQuery/jquery-3.6.4.js"></script>
            <script>
            // Додайте обробник події для кнопки після завантаження сторінки
            $(document).ready(function() {
                $("#'.$buttonId.'").on("click", function() {
                    // Перенаправлення на стартову сторінку
                    window.location.href = "/WC_2_SYS_select_date/WC_2_start.php";
                    // Завершення сесії
                    $.ajax({
                        url: "/session/WC_2_end_sesion.php",
                        type: "POST",
                        success: function(response) {
                            console.log("Сесію завершено.");
                        },
                        error: function(error) {
                            console.log("Помилка під час завершення сесії.");
                        }
                    });
                });
            });
            </script>';
  }
  







  public static function loadContent($url, $div_name) {
    echo '<script src="/jQuery/jquery-3.6.4.js"></script>
          <script>
          $(document).ready(function() {
              // Виконуємо AJAX-запит і вставляємо відповідь у вказаний div-елемент
              $.ajax({
                url: "'.$url.'",
                success: function(data) {
                  $(".'.$div_name.'").html(data);
                }
              });
          });
          </script>';
  }
  
  
/*======================================переві===============================================================================*/
/*
public function checkFile() {
    if ($this->fileInput->value) {
      $this->submitBtn->disabled = false;
    } else {
      $this->submitBtn->disabled = true;
    }
  }
*/
/*=====================================================================================================================*/


}
/*--------------------------------END------------------------------------*/
/*=====================================================================================================================*/

//echo "<br> -----====== file conect WC_2_all_class.php ===---------<br>";
?>
