<?php


// Підключаємося до бази даних
$conn = new PDO('oci:dbname=//10.6.108.18:1521/dell720', 'test_c', 'test_c');

if ($conn) {
    echo 'Connected<br>';

    $query = 'SELECT * FROM cioc_conf';
    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo $row['login'] . ' ' . $row['pass'] . '<br>';
        }
    } else {
        echo 'Query failed';
    }
} else {
    echo 'Connection failed';
}



?>

