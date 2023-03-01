
			<?php
				echo '<link rel="stylesheet" href="/work_table_create/css/WTC_first.css">';
				
				/*require_once ("/work_table_create/Work_Class/W_C_all.php");*/

				require_once __DIR__ . '/Work_Class/W_C_all.php';

                


// Приклад використання класу та методу
$servername = "localhost";
$username = "gelo4891";
$password = "gelo1111";
$dbname = "base_o_zvit";
$class_Name="BT_Class_Name";


$workClass = new WorkClassAll ('mysql', $servername, '3306', $username, $password, $dbname);

// Connect to the database
$workClass->WCA_connect_to_base();

// Execute a SQL query
$query = "SELECT * FROM boz_perelik_table";
$result = $workClass->WCA_query_sql($query);

// Display the results as a table
echo $workClass->WCA_BuildTable($result,$class_Name);


$query = "update boz_perelik_table set PT_number='1' where  PT_number='uniqer'";
$result = $workClass->WCA_query_sql($query);

echo $result ;

// Display the results as a table


$query = "SELECT * FROM boz_perelik_table";
$result = $workClass->WCA_query_sql($query);

// Display the results as a table
echo $workClass->WCA_BuildTable($result,$class_Name);




?>


