<?php
require_once __DIR__ . '../../WC_2_Class/WC_2_all_class.php';

/*------------------------------------*/
$qb = new WorkClassAll ('1','1','1','1','1','1','1');

/*------------------------------------*/
echo "<br>";
echo "<br>SELECT---->";
echo $query = $qb->WC_buildQuery('select', 'users', array('fields' => 'id, username, email'), array(), 'id ASC', '10');


echo "<br>";
echo "<br>INSERT---->";

$data1 = array(
    'username' => 'johndoe',
    'password' => 'mypassword',
    'email' => 'johndoe@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe'
);
echo $query1 = $qb->WC_buildQuery('insert', 'users', $data1);



echo "<br>";
echo "<br>Update---->";
$data2 = array(
    'password' => 'newpassword',
    'first_name' => 'John',
    'last_name' => 'Doe'
);

$where2 = array(
    'id' => 1,
    'ee' => 2222222,
    'vv' => 22233332
);

echo $query2 = $qb->WC_buildQuery('update', 'users', $data2, $where2);

echo "<br>";
echo "<br>Delete---->";
$where3 = array(
    'status' => 'inactive'
);
echo $query3 = $qb->WC_buildQuery('delete', 'users', array(), $where3);



//WC_buildQuery($WCA_dbType, $WCA_table, $data = array(), $conditions = array(), $orderBy = '', $limit = '')
?>

