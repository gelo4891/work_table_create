<?php
require_once __DIR__ . '../../WC_2_Class/WC_2_all_class.php';

/*------------------------------------*/
$qb = new WorkClassAll ('1','1','1','1','1','1','1','1','1');
echo $query = $qb->WC_buildQuery_system('mysql', 'users', ['name' => 'John', 'age' => 25], ['id' => 1, 'id1' => 2]);
/*------------------------------------*/
echo "<br>";
echo "<br>SELECT---->";
echo $query1 = $qb->WC_buildQuery('select', 'My_User_Table', ['name' => 'John', 'age' => 25], ['id' => 1, 'id1' => 2],'test1','test2');
echo "<br>";
echo "<br>INSERT---->";
echo $query1 = $qb->WC_buildQuery('insert', 'My_User_Table', ['name' => 'John', 'age' => 25], ['id' => 1],'test1','test2');

echo "<br>";
echo "<br>Update---->";
echo $query1 = $qb->WC_buildQuery('update', 'My_User_Table', ['name' => 'John', 'age' => 25], ['id' => 1]);

echo "<br>";
echo "<br>Delete---->";
echo $query1 = $qb->WC_buildQuery('delete', 'My_User_Table', ['name' => 'John', 'age' => 25], ['id' => 1]);





//WC_buildQuery($WCA_dbType, $WCA_table, $data = array(), $conditions = array(), $orderBy = '', $limit = '')
?>

